<?php

namespace app\service;

use app\constants\CollectionOrder;
use app\constants\DisbursementOrder;
use app\repository\BankAccountRepository;
use app\repository\ChannelAccountDailyStatsRepository;
use app\repository\ChannelAccountRepository;
use app\repository\CollectionOrderRepository;
use app\repository\DisbursementOrderRepository;
use Carbon\Carbon;
use DI\Attribute\Inject;
use support\Log;
use support\Db;
use Throwable;

final class ChannelAccountDailyStatsService extends IService
{
    #[Inject]
    public ChannelAccountDailyStatsRepository $repository;

    #[Inject]
    public ChannelAccountRepository $channelAccountRepository;

    #[Inject]
    public BankAccountRepository $bankAccountRepository;

    #[Inject]
    public CollectionOrderRepository $collectionOrderRepository;

    #[Inject]
    public DisbursementOrderRepository $disbursementOrderRepository;

    // 缓存账户配置，避免重复查询
    private array $accountCache = [];

    // 每分钟定时统计
    public function minutelyStatsCron(): void
    {
        $currentTime = Carbon::now();
        $todayDate = $currentTime->format('Y-m-d');

        try {
            Log::info("开始每分钟统计渠道账户数据", [
                'stat_date'    => $todayDate,
                'current_time' => $currentTime->format('Y-m-d H:i:s')
            ]);

            // 统计所有账户的每日数据
            $this->processAllAccountStats($todayDate);

            Log::info("每分钟渠道账户统计任务完成", [
                'stat_date'      => $todayDate,
                'execution_time' => $currentTime->format('Y-m-d H:i:s')
            ]);
        } catch (Throwable $e) {
            Log::error("每分钟渠道账户统计任务失败", [
                'stat_date'     => $todayDate,
                'current_time'  => $currentTime->format('Y-m-d H:i:s'),
                'error_message' => $e->getMessage(),
                'error_file'    => $e->getFile() . ':' . $e->getLine(),
                'trace'         => $e->getTraceAsString()
            ]);

            throw $e;
        } finally {
            // 清理缓存
            $this->accountCache = [];
        }
    }

    // 每日定时1点统计（保留用于历史数据统计）
    public function dailyStatsCron(): void
    {
        $yesterdayDate = Carbon::yesterday()->format('Y-m-d');

        try {
            Log::info("开始统计渠道账户每日数据", ['stat_date' => $yesterdayDate]);

            // 统计所有账户的每日数据
            $this->processAllAccountStats($yesterdayDate);

            Log::info("渠道账户每日统计任务完成", ['stat_date' => $yesterdayDate]);
        } catch (Throwable $e) {
            Log::error("渠道账户每日统计任务失败", [
                'stat_date'     => $yesterdayDate,
                'error_message' => $e->getMessage(),
                'error_file'    => $e->getFile() . ':' . $e->getLine(),
                'trace'         => $e->getTraceAsString()
            ]);

            throw $e;
        } finally {
            // 清理缓存
            $this->accountCache = [];
        }
    }

    /**
     * 统计所有账户的每日数据 - 批量优化版本
     */
    private function processAllAccountStats(string $statDate): void
    {
        // 获取所有活跃的账户ID
        $activeAccounts = $this->getActiveAccounts($statDate);

        if (empty($activeAccounts)) {
            Log::info("当日无活跃账户", ['stat_date' => $statDate]);
            return;
        }

        // 批量预载入账户信息到缓存
        $this->preloadAccountCache($activeAccounts);

        // 使用批量处理减少数据库压力
        $batchSize = 50; // 每批处理50个账户
        $batches = array_chunk($activeAccounts, $batchSize);

        foreach ($batches as $batchIndex => $batch) {
            Log::debug("处理账户批次", [
                'stat_date'     => $statDate,
                'batch_index'   => $batchIndex + 1,
                'batch_size'    => count($batch),
                'total_batches' => count($batches)
            ]);

            foreach ($batch as $account) {
                try {
                    $this->processAccountDailyStats($account, $statDate);
                } catch (Throwable $e) {
                    Log::error("处理账户统计失败", [
                        'stat_date' => $statDate,
                        'account'   => $account,
                        'error'     => $e->getMessage()
                    ]);
                    // 继续处理其他账户，不中断整个批次
                }
            }

            // 批次间短暂休息，避免数据库压力过大
            if ($batchIndex < count($batches) - 1) {
                usleep(100000); // 休息100ms
            }
        }

        Log::info("账户每日统计数据处理完成", [
            'stat_date'          => $statDate,
            'processed_accounts' => count($activeAccounts),
            'processed_batches'  => count($batches)
        ]);
    }

    /**
     * 批量预载入账户信息到缓存
     */
    private function preloadAccountCache(array $activeAccounts): void
    {
        // 分组收集账户ID
        $channelAccountIds = [];
        $bankAccountIds = [];

        foreach ($activeAccounts as $account) {
            if ($account['type'] === 'channel') {
                $channelAccountIds[] = $account['account_id'];
            } else {
                $bankAccountIds[] = $account['account_id'];
            }
        }

        // 批量查询渠道账户
        if (!empty($channelAccountIds)) {
            $channelAccounts = $this->channelAccountRepository->getQuery()
                ->whereIn('id', array_unique($channelAccountIds))
                ->get()
                ->keyBy('id');

            foreach ($channelAccounts as $account) {
                $this->accountCache['channel_' . $account->id] = $account;
            }
        }

        // 批量查询银行账户
        if (!empty($bankAccountIds)) {
            $bankAccounts = $this->bankAccountRepository->getQuery()
                ->whereIn('id', array_unique($bankAccountIds))
                ->get()
                ->keyBy('id');

            foreach ($bankAccounts as $account) {
                $this->accountCache['bank_' . $account->id] = $account;
            }
        }

        Log::debug("预载入账户缓存完成", [
            'channel_accounts' => count($channelAccountIds),
            'bank_accounts'    => count($bankAccountIds)
        ]);
    }

    /**
     * 获取活跃账户（有交易记录的账户）- 优化版本
     */
    private function getActiveAccounts(string $statDate): array
    {
        // 优化的 SQL 查询 - 在数据库层面去重，减少 PHP 处理
        $unionSql = <<<SQL
            SELECT DISTINCT
                account_id,
                channel_id,
                type
            FROM (
                (SELECT DISTINCT
                    channel_account_id as account_id,
                    collection_channel_id as channel_id,
                    'channel' as type
                FROM collection_order
                WHERE DATE(created_at) = ? AND channel_account_id IS NOT NULL)
                UNION ALL
                (SELECT DISTINCT
                    channel_account_id as account_id,
                    disbursement_channel_id as channel_id,
                    'channel' as type
                FROM disbursement_order
                WHERE DATE(created_at) = ? AND channel_account_id IS NOT NULL)
                UNION ALL
                (SELECT DISTINCT
                    bank_account_id as account_id,
                    collection_channel_id as channel_id,
                    'bank' as type
                FROM collection_order
                WHERE DATE(created_at) = ? AND bank_account_id IS NOT NULL AND channel_account_id IS NULL)
                UNION ALL
                (SELECT DISTINCT
                    bank_account_id as account_id,
                    disbursement_channel_id as channel_id,
                    'bank' as type
                FROM disbursement_order
                WHERE DATE(created_at) = ? AND bank_account_id IS NOT NULL AND channel_account_id IS NULL)
            ) AS combined_accounts
        SQL;

        $results = Db::select($unionSql, [$statDate, $statDate, $statDate, $statDate]);

        // 直接转换结果，无需额外去重处理
        return array_map(function ($item) {
            return [
                'type'       => $item->type,
                'account_id' => (int)$item->account_id,
                'channel_id' => (int)$item->channel_id,
            ];
        }, $results);
    }

    /**
     * 处理单个账户的每日统计
     */
    private function processAccountDailyStats(array $accountInfo, string $statDate): void
    {
        // 统计收款数据
        $collectionStats = $this->getOrderStats($accountInfo, $statDate, 'collection');

        // 统计付款数据
        $disbursementStats = $this->getOrderStats($accountInfo, $statDate, 'disbursement');

        // 合并统计数据并保存
        $this->upsertDailyStats($accountInfo, $statDate, $collectionStats, $disbursementStats);
    }

    /**
     * 获取订单统计数据
     */
    private function getOrderStats(array $accountInfo, string $statDate, string $type): array
    {
        $isCollection = $type === 'collection';
        $repository = $isCollection ? $this->collectionOrderRepository : $this->disbursementOrderRepository;
        $successStatus = $isCollection ? CollectionOrder::STATUS_SUCCESS : DisbursementOrder::STATUS_SUCCESS;
        $amountField = $isCollection ? 'paid_amount' : 'amount';
        $accountField = $accountInfo['type'] === 'channel' ? 'channel_account_id' : 'bank_account_id';

        $stats = $repository->getQuery()
            ->selectRaw(
                "COUNT(*) as transaction_count,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as success_count,
                SUM(CASE WHEN status != ? THEN 1 ELSE 0 END) as failure_count,
                SUM(CASE WHEN status = ? THEN {$amountField} ELSE 0 END) as amount_total,
                AVG(CASE WHEN status = ? AND pay_time IS NOT NULL
                    THEN TIMESTAMPDIFF(SECOND, created_at, pay_time)
                    ELSE NULL END) as avg_process_time",
                [$successStatus, $successStatus, $successStatus, $successStatus]
            )
            ->whereDate('created_at', $statDate)
            ->where($accountField, $accountInfo['account_id'])
            ->first();

        return [
            'transaction_count' => $stats->transaction_count ?? 0,
            'success_count'     => $stats->success_count ?? 0,
            'failure_count'     => $stats->failure_count ?? 0,
            'amount_total'      => $stats->amount_total ?? 0,
            'avg_process_time'  => $stats->avg_process_time ?? 0,
        ];
    }

    /**
     * 更新或插入每日统计数据
     */
    private function upsertDailyStats(array $accountInfo, string $statDate, array $collectionStats, array $disbursementStats): void
    {
        $accountType = $accountInfo['type'];
        $accountId = $accountInfo['account_id'];
        $channelId = $accountInfo['channel_id'];

        // 构建查询条件和数据
        if ($accountType === 'channel') {
            // 上游渠道账户
            $channelAccountId = $accountId;
            $bankAccountId = 0;
        } else {
            // 银行账户
            $channelAccountId = 0;
            $bankAccountId = $accountId;
        }

        // 查询现有记录
        $existingRecord = $this->repository->findByAccountAndDate($channelAccountId, $bankAccountId, $statDate);

        // 计算收款成功率和付款成功率
        $collectionTotalCount = $collectionStats['success_count'] + $collectionStats['failure_count'];
        $collectionSuccessRate = $collectionTotalCount > 0
            ? round(($collectionStats['success_count'] / $collectionTotalCount) * 100, 2)
            : 0;

        $disbursementTotalCount = $disbursementStats['success_count'] + $disbursementStats['failure_count'];
        $disbursementSuccessRate = $disbursementTotalCount > 0
            ? round(($disbursementStats['success_count'] / $disbursementTotalCount) * 100, 2)
            : 0;

        // 计算平均处理时间
        $avgProcessTime = 0;
        if ($collectionStats['avg_process_time'] > 0 && $disbursementStats['avg_process_time'] > 0) {
            $avgProcessTime = ($collectionStats['avg_process_time'] + $disbursementStats['avg_process_time']) / 2;
        } elseif ($collectionStats['avg_process_time'] > 0) {
            $avgProcessTime = $collectionStats['avg_process_time'];
        } elseif ($disbursementStats['avg_process_time'] > 0) {
            $avgProcessTime = $disbursementStats['avg_process_time'];
        }

        $data = [
            'channel_account_id'             => $channelAccountId,
            'bank_account_id'                => $bankAccountId,
            'channel_id'                     => $channelId,
            'stat_date'                      => $statDate,
            'collection_transaction_count'   => $collectionStats['transaction_count'],
            'disbursement_transaction_count' => $disbursementStats['transaction_count'],
            'collection_success_count'       => $collectionStats['success_count'],
            'collection_failure_count'       => $collectionStats['failure_count'],
            'disbursement_success_count'     => $disbursementStats['success_count'],
            'disbursement_failure_count'     => $disbursementStats['failure_count'],
            'receipt_amount'                 => $collectionStats['amount_total'],
            'payment_amount'                 => $disbursementStats['amount_total'],
            'collection_success_rate'        => $collectionSuccessRate,
            'disbursement_success_rate'      => $disbursementSuccessRate,
            'avg_process_time'               => (int)$avgProcessTime,
            'updated_at'                     => Carbon::now(),
        ];

        // 检查是否是当日统计（实时统计）
        $isToday = $statDate === Carbon::today()->format('Y-m-d');

        // 只有当日统计才计算限额状态
        if ($isToday) {
            $data['limit_status'] = $this->calculateLimitStatus($accountType, $accountId);
        }

        // 使用updateOrCreate方法
        $conditions = [
            'channel_account_id' => $channelAccountId,
            'bank_account_id'    => $bankAccountId,
            'stat_date'          => $statDate
        ];

        $record = $this->repository->updateOrCreateStats($conditions, $data);

        Log::debug($existingRecord ? "更新每日统计记录" : "创建每日统计记录",
            array_merge($data, ['record_id' => $record->id])
        );
    }

    /**
     * 计算限额状态
     * 0正常：所有指标都没有超过限制配置
     * 1部分限额：部分指标超过了限制配置
     * 2全部限额：所有指标都超过限制配置
     */
    private function calculateLimitStatus(string $accountType, int $accountId): int
    {
        try {
            // 获取账户配置
            $account = $this->getAccountFromCache($accountType, $accountId);

            if (!$account) {
                Log::warning("账户不存在", ['account_type' => $accountType, 'account_id' => $accountId]);
                return 2; // 完全限额（安全考虑）
            }

            // 获取实时数据
            $todayReceiptAmount = $account->today_receipt_amount ?? 0;
            $todayReceiptCount = $account->today_receipt_count ?? 0;
            $todayPaymentAmount = $account->today_payment_amount ?? 0;
            $todayPaymentCount = $account->today_payment_count ?? 0;
            $used_quota = $account->used_quota ?? 0;

            $limitChecks = [];

            // 检查收款金额限制（配置为0表示不限制）
            if (isset($account->daily_max_receipt) && $account->daily_max_receipt > 0) {
                $limitChecks['receipt_amount'] = $todayReceiptAmount >= $account->daily_max_receipt;
            }

            // 检查收款次数限制（配置为0表示不限制）
            if (isset($account->daily_max_receipt_count) && $account->daily_max_receipt_count > 0) {
                $limitChecks['receipt_count'] = $todayReceiptCount >= $account->daily_max_receipt_count;
            }

            // 检查付款金额限制（配置为0表示不限制）
            if (isset($account->daily_max_payment) && $account->daily_max_payment > 0) {
                $limitChecks['payment_amount'] = $todayPaymentAmount >= $account->daily_max_payment;
            }

            // 检查付款次数限制（配置为0表示不限制）
            if (isset($account->daily_max_payment_count) && $account->daily_max_payment_count > 0) {
                $limitChecks['payment_count'] = $todayPaymentCount >= $account->daily_max_payment_count;
            }

            if (isset($account->limit_quota) && $account->limit_quota > 0) {
                $limitChecks['used_quota'] = $used_quota >= $account->limit_quota;
            }

            return $this->determineLimitStatus($limitChecks, $accountType, $accountId, [
                'today_receipt_amount' => $todayReceiptAmount,
                'today_receipt_count'  => $todayReceiptCount,
                'today_payment_amount' => $todayPaymentAmount,
                'today_payment_count'  => $todayPaymentCount,
            ]);

        } catch (Throwable $e) {
            Log::error("计算限额状态失败", [
                'account_type' => $accountType,
                'account_id'   => $accountId,
                'error'        => $e->getMessage()
            ]);
            return 2; // 发生错误时返回完全限额（安全考虑）
        }
    }

    /**
     * 根据限制检查结果确定限额状态
     */
    private function determineLimitStatus(array $limitChecks, string $accountType, int $accountId, array $logData): int
    {
        // 如果没有配置任何限制，返回正常
        if (empty($limitChecks)) {
            return 0;
        }

        $exceededChecks = array_filter($limitChecks);
        $totalChecks = count($limitChecks);
        $exceededCount = count($exceededChecks);

        // 记录限额状态变化日志
        if ($exceededCount > 0) {
            Log::info("账户限额状态检查", array_merge([
                'account_type'    => $accountType,
                'account_id'      => $accountId,
                'exceeded_checks' => array_keys($exceededChecks),
                'total_checks'    => $totalChecks,
                'exceeded_count'  => $exceededCount
            ], $logData));
        }

        // 根据超限指标数量判断限额状态
        if ($exceededCount == 0) {
            return 0; // 正常
        } elseif ($exceededCount == $totalChecks) {
            return 2; // 全部限额
        } else {
            return 1; // 部分限额
        }
    }

    /**
     * 从缓存获取账户配置
     */
    private function getAccountFromCache(string $accountType, int $accountId): ?object
    {
        $cacheKey = $accountType . '_' . $accountId;

        if (!isset($this->accountCache[$cacheKey])) {
            if ($accountType === 'channel') {
                $this->accountCache[$cacheKey] = $this->channelAccountRepository->findById($accountId);
            } else {
                $this->accountCache[$cacheKey] = $this->bankAccountRepository->findById($accountId);
            }
        }

        return $this->accountCache[$cacheKey];
    }
}