<?php

namespace app\service;

use app\constants\CollectionOrder;
use app\constants\DisbursementOrder;
use app\repository\ChannelAccountDailyStatsRepository;
use app\repository\ChannelAccountRepository;
use app\repository\CollectionOrderRepository;
use app\repository\DisbursementOrderRepository;
use Carbon\Carbon;
use DI\Attribute\Inject;
use support\Log;
use Throwable;

final class ChannelAccountDailyStatsService extends IService
{
    #[Inject]
    public ChannelAccountDailyStatsRepository $repository;

    #[Inject]
    public ChannelAccountRepository $channelAccountRepository;

    #[Inject]
    public CollectionOrderRepository $collectionOrderRepository;

    #[Inject]
    public DisbursementOrderRepository $disbursementOrderRepository;

    // 缓存渠道账户配置，避免重复查询
    private array $channelAccountCache = [];

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

            // 统计收款订单数据
            $this->processOrderStats($todayDate, 'collection');

            // 统计付款订单数据
            $this->processOrderStats($todayDate, 'disbursement');

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

            // 重新抛出异常，让上层处理
            throw $e;
        } finally {
            // 清理缓存
            $this->channelAccountCache = [];

            Log::debug("渠道账户统计任务资源清理完成", [
                'stat_date'      => $todayDate,
                'execution_time' => $currentTime->format('Y-m-d H:i:s')
            ]);
        }
    }

    // 每日定时1点统计（保留用于历史数据统计）
    public function dailyStatsCron(): void
    {
        $yesterdayDate = Carbon::yesterday()->format('Y-m-d');

        try {
            Log::info("开始统计渠道账户每日数据", ['stat_date' => $yesterdayDate]);

            // 统计收款订单数据
            $this->processOrderStats($yesterdayDate, 'collection');

            // 统计付款订单数据
            $this->processOrderStats($yesterdayDate, 'disbursement');

            Log::info("渠道账户每日统计任务完成", ['stat_date' => $yesterdayDate]);
        } catch (Throwable $e) {
            Log::error("渠道账户每日统计任务失败", [
                'stat_date'     => $yesterdayDate,
                'error_message' => $e->getMessage(),
                'error_file'    => $e->getFile() . ':' . $e->getLine(),
                'trace'         => $e->getTraceAsString()
            ]);

            // 重新抛出异常，让上层处理
            throw $e;
        } finally {
            // 清理缓存
            $this->channelAccountCache = [];

            Log::info("渠道账户统计任务资源清理完成", ['stat_date' => $yesterdayDate]);
        }
    }

    /**
     * 统计订单数据通用方法
     */
    private function processOrderStats(string $statDate, string $type): void
    {
        Log::info("开始统计{$type}订单数据", ['stat_date' => $statDate, 'type' => $type]);

        $isCollection = $type === 'collection';
        $repository = $isCollection ? $this->collectionOrderRepository : $this->disbursementOrderRepository;
        $successStatus = $isCollection ? CollectionOrder::STATUS_SUCCESS : DisbursementOrder::STATUS_SUCCESS;
        $channelIdField = $isCollection ? 'collection_channel_id' : 'disbursement_channel_id';
        $amountField = $isCollection ? 'paid_amount' : 'amount';
        $amountAlias = $isCollection ? 'receipt_amount' : 'payment_amount';

        $stats = $repository->getQuery()
            ->selectRaw(
                "channel_account_id,
                bank_account_id,
                {$channelIdField} as channel_id,
                COUNT(*) as transaction_count,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as success_count,
                SUM(CASE WHEN status != ? THEN 1 ELSE 0 END) as failure_count,
                SUM(CASE WHEN status = ? THEN {$amountField} ELSE 0 END) as {$amountAlias},
                AVG(CASE WHEN status = ? AND pay_time IS NOT NULL
                    THEN TIMESTAMPDIFF(MICROSECOND, created_at, pay_time) / 1000
                    ELSE NULL END) as avg_process_time",
                [$successStatus, $successStatus, $successStatus, $successStatus]
            )
            ->whereDate('created_at', $statDate)
            ->whereNotNull('channel_account_id')
            ->groupBy('channel_account_id', 'bank_account_id', $channelIdField)
            ->get();

        foreach ($stats as $stat) {
            $this->upsertDailyStats($stat, $statDate, $type);
        }

        Log::info("{$type}订单数据统计完成", [
            'stat_date'         => $statDate,
            'type'              => $type,
            'records_processed' => $stats->count()
        ]);
    }

    /**
     * 更新或插入每日统计数据
     */
    private function upsertDailyStats(object $stat, string $statDate, string $type): void
    {
        if (!$stat->channel_account_id) {
            return;
        }

        // 计算成功率
        $successRate = $stat->transaction_count > 0
            ? round(($stat->success_count / $stat->transaction_count) * 100, 2)
            : 0;

        // 获取现有记录
        $existingRecord = $this->repository->getQuery()
            ->where('channel_account_id', $stat->channel_account_id)
            ->where('stat_date', $statDate)
            ->first();

        $data = [
            'channel_account_id' => $stat->channel_account_id,
            'bank_account_id'    => $stat->bank_account_id ?? 0,
            'channel_id'         => $stat->channel_id ?? 0,
            'stat_date'          => $statDate,
        ];

        // 检查是否是当日统计（实时统计）
        $isToday = $statDate === Carbon::today()->format('Y-m-d');

        if ($existingRecord) {
            // 更新现有记录
            $updateData = $this->calculateUpdateData($existingRecord, $stat, $type);

            // 只有当日统计才计算实时限额状态
            if ($isToday) {
                $updateData['limit_status'] = $this->calculateLimitStatus($stat->channel_account_id);
            } else {
                // 历史数据使用基于统计数据的限额状态计算
                $updateData['limit_status'] = $this->calculateHistoricalLimitStatus($stat->channel_account_id, $updateData, $statDate);
            }

            $this->repository->updateById($existingRecord->id, $updateData);

            Log::debug("更新每日统计记录", [
                'channel_account_id' => $stat->channel_account_id,
                'stat_date'          => $statDate,
                'type'               => $type,
                'is_today'           => $isToday,
                'data'               => $updateData
            ]);
        } else {
            // 创建新记录
            $createData = array_merge($data, [
                'transaction_count' => $stat->transaction_count,
                'success_count'     => $stat->success_count,
                'failure_count'     => $stat->failure_count,
                'receipt_amount'    => $type === 'collection' ? ($stat->receipt_amount ?? 0) : 0,
                'payment_amount'    => $type === 'disbursement' ? ($stat->payment_amount ?? 0) : 0,
                'success_rate'      => $successRate,
                'avg_process_time'  => !empty($stat->avg_process_time) ? (int)$stat->avg_process_time : 0,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);

            // 只有当日统计才计算实时限额状态
            if ($isToday) {
                $createData['limit_status'] = $this->calculateLimitStatus($stat->channel_account_id);
            } else {
                // 历史数据使用基于统计数据的限额状态计算
                $createData['limit_status'] = $this->calculateHistoricalLimitStatus($stat->channel_account_id, $createData, $statDate);
            }

            $this->repository->create($createData);

            Log::debug("创建每日统计记录", [
                'channel_account_id' => $stat->channel_account_id,
                'stat_date'          => $statDate,
                'type'               => $type,
                'is_today'           => $isToday,
                'data'               => $createData
            ]);
        }
    }

    /**
     * 批量统计多个渠道账户数据（用于大数据量处理）
     */
    public function batchDailyStats(string $statDate, array $channelAccountIds = []): void
    {
        try {
            Log::info("开始批量统计渠道账户每日数据", [
                'stat_date'             => $statDate,
                'channel_account_count' => count($channelAccountIds)
            ]);

            // 如果没有指定账户ID，获取所有活跃账户
            if (empty($channelAccountIds)) {
                $channelAccountIds = $this->getActiveChannelAccountIds($statDate);
            }

            // 分批处理，避免内存溢出
            $batchSize = 100;
            $chunks = array_chunk($channelAccountIds, $batchSize);

            foreach ($chunks as $index => $chunk) {
                Log::info("处理第" . ($index + 1) . "批渠道账户", [
                    'batch_size'    => count($chunk),
                    'total_batches' => count($chunks)
                ]);

                $this->processBatchStats($statDate, $chunk);
            }

            Log::info("批量统计渠道账户每日数据完成", [
                'stat_date'       => $statDate,
                'total_processed' => count($channelAccountIds)
            ]);

        } catch (Throwable $e) {
            Log::error("批量统计任务失败", [
                'stat_date' => $statDate,
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * 获取指定日期的活跃渠道账户ID
     */
    private function getActiveChannelAccountIds(string $statDate): array
    {
        // 获取当天有交易的渠道账户ID
        $collectionIds = $this->collectionOrderRepository->getQuery()
            ->whereDate('created_at', $statDate)
            ->whereNotNull('channel_account_id')
            ->distinct()
            ->pluck('channel_account_id')
            ->toArray();

        $disbursementIds = $this->disbursementOrderRepository->getQuery()
            ->whereDate('created_at', $statDate)
            ->whereNotNull('channel_account_id')
            ->distinct()
            ->pluck('channel_account_id')
            ->toArray();

        return array_unique(array_merge($collectionIds, $disbursementIds));
    }

    /**
     * 处理一批渠道账户统计
     */
    private function processBatchStats(string $statDate, array $channelAccountIds): void
    {
        // 批量统计收款订单
        $this->processBatchOrderStats($statDate, 'collection', $channelAccountIds);

        // 批量统计付款订单
        $this->processBatchOrderStats($statDate, 'disbursement', $channelAccountIds);
    }

    /**
     * 批量处理订单统计
     */
    private function processBatchOrderStats(string $statDate, string $type, array $channelAccountIds): void
    {
        $isCollection = $type === 'collection';
        $repository = $isCollection ? $this->collectionOrderRepository : $this->disbursementOrderRepository;
        $successStatus = $isCollection ? CollectionOrder::STATUS_SUCCESS : DisbursementOrder::STATUS_SUCCESS;
        $channelIdField = $isCollection ? 'collection_channel_id' : 'disbursement_channel_id';
        $amountField = $isCollection ? 'paid_amount' : 'amount';
        $amountAlias = $isCollection ? 'receipt_amount' : 'payment_amount';

        $stats = $repository->getQuery()
            ->selectRaw(
                "channel_account_id,
                bank_account_id,
                {$channelIdField} as channel_id,
                COUNT(*) as transaction_count,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as success_count,
                SUM(CASE WHEN status != ? THEN 1 ELSE 0 END) as failure_count,
                SUM(CASE WHEN status = ? THEN {$amountField} ELSE 0 END) as {$amountAlias},
                AVG(CASE WHEN status = ? AND pay_time IS NOT NULL
                    THEN TIMESTAMPDIFF(MICROSECOND, created_at, pay_time) / 1000
                    ELSE NULL END) as avg_process_time",
                [$successStatus, $successStatus, $successStatus, $successStatus]
            )
            ->whereDate('created_at', $statDate)
            ->whereIn('channel_account_id', $channelAccountIds)
            ->groupBy('channel_account_id', 'bank_account_id', $channelIdField)
            ->get();

        foreach ($stats as $stat) {
            $this->upsertDailyStats($stat, $statDate, $type);
        }
    }

    /**
     * 计算数据的更新值
     */
    private function calculateUpdateData(object $existingRecord, object $stat, string $type): array
    {
        $updateData = [
            'transaction_count' => ($existingRecord->transaction_count ?? 0) + $stat->transaction_count,
            'success_count'     => ($existingRecord->success_count ?? 0) + $stat->success_count,
            'failure_count'     => ($existingRecord->failure_count ?? 0) + $stat->failure_count,
        ];

        if ($type === 'collection') {
            $updateData['receipt_amount'] = ($existingRecord->receipt_amount ?? 0) + ($stat->receipt_amount ?? 0);
        } else {
            $updateData['payment_amount'] = ($existingRecord->payment_amount ?? 0) + ($stat->payment_amount ?? 0);
        }

        // 重新计算成功率
        $totalTransactions = $updateData['transaction_count'];
        $updateData['success_rate'] = $totalTransactions > 0
            ? round(($updateData['success_count'] / $totalTransactions) * 100, 2)
            : 0;

        // 更新平均处理时间
        if (!empty($stat->avg_process_time)) {
            $updateData['avg_process_time'] = (int)$stat->avg_process_time;
        }

        return $updateData;
    }

    /**
     * 计算限额状态（基于实时数据）
     * 0正常：所有指标都没有超过限制配置
     * 1部分限额：部分指标超过了限制配置
     * 2全部限额：所有指标都超过限制配置
     */
    private function calculateLimitStatus(int $channelAccountId): int
    {
        try {
            // 使用缓存获取渠道账户配置
            $channelAccount = $this->getChannelAccountFromCache($channelAccountId);

            if (!$channelAccount) {
                Log::warning("渠道账户不存在", ['channel_account_id' => $channelAccountId]);
                return 2; // 完全限额（安全考虑）
            }

            // 获取实时数据（channel_account表中的当日收款/付款数据）
            $todayReceiptAmount = $channelAccount->today_receipt_amount ?? 0;
            $todayReceiptCount = $channelAccount->today_receipt_count ?? 0;
            $todayPaymentAmount = $channelAccount->today_payment_amount ?? 0;
            $todayPaymentCount = $channelAccount->today_payment_count ?? 0;

            $limitChecks = [];

            // 检查收款金额限制
            if ($channelAccount->daily_max_receipt > 0) {
                $limitChecks['receipt_amount'] = $todayReceiptAmount >= $channelAccount->daily_max_receipt;
            }

            // 检查收款次数限制
            if ($channelAccount->daily_max_receipt_count > 0) {
                $limitChecks['receipt_count'] = $todayReceiptCount >= $channelAccount->daily_max_receipt_count;
            }

            // 检查付款金额限制
            if ($channelAccount->daily_max_payment > 0) {
                $limitChecks['payment_amount'] = $todayPaymentAmount >= $channelAccount->daily_max_payment;
            }

            // 检查付款次数限制
            if ($channelAccount->daily_max_payment_count > 0) {
                $limitChecks['payment_count'] = $todayPaymentCount >= $channelAccount->daily_max_payment_count;
            }

            // 检查总额度限制
            if ($channelAccount->limit_quota > 0 && $channelAccount->used_quota > 0) {
                $limitChecks['total_quota'] = $channelAccount->used_quota >= $channelAccount->limit_quota;
            }

            return $this->determineLimitStatus($limitChecks, $channelAccountId, [
                'today_receipt_amount' => $todayReceiptAmount,
                'today_receipt_count'  => $todayReceiptCount,
                'today_payment_amount' => $todayPaymentAmount,
                'today_payment_count'  => $todayPaymentCount,
            ]);

        } catch (Throwable $e) {
            Log::error("计算限额状态失败", [
                'channel_account_id' => $channelAccountId,
                'error'              => $e->getMessage()
            ]);
            return 2; // 发生错误时返回完全限额（安全考虑）
        }
    }

    /**
     * 计算历史数据的限额状态（基于统计数据）
     */
    private function calculateHistoricalLimitStatus(int $channelAccountId, array $statsData, string $statDate): int
    {
        try {
            // 使用缓存获取渠道账户配置
            $channelAccount = $this->getChannelAccountFromCache($channelAccountId);

            if (!$channelAccount) {
                Log::warning("渠道账户不存在", ['channel_account_id' => $channelAccountId]);
                return 2; // 完全限额（安全考虑）
            }

            // 获取指定日期的交易次数（基于订单统计）
            $receiptCount = $this->getReceiptCountForDate($channelAccountId, $statDate);
            $paymentCount = $this->getPaymentCountForDate($channelAccountId, $statDate);

            // 从统计数据中获取金额
            $receiptAmount = $statsData['receipt_amount'] ?? 0;
            $paymentAmount = $statsData['payment_amount'] ?? 0;

            $limitChecks = [];

            // 检查收款金额限制
            if ($channelAccount->daily_max_receipt > 0) {
                $limitChecks['receipt_amount'] = $receiptAmount >= $channelAccount->daily_max_receipt;
            }

            // 检查收款次数限制
            if ($channelAccount->daily_max_receipt_count > 0) {
                $limitChecks['receipt_count'] = $receiptCount >= $channelAccount->daily_max_receipt_count;
            }

            // 检查付款金额限制
            if ($channelAccount->daily_max_payment > 0) {
                $limitChecks['payment_amount'] = $paymentAmount >= $channelAccount->daily_max_payment;
            }

            // 检查付款次数限制
            if ($channelAccount->daily_max_payment_count > 0) {
                $limitChecks['payment_count'] = $paymentCount >= $channelAccount->daily_max_payment_count;
            }

            // 历史数据不检查总额度（因为总额度是累计的）

            return $this->determineLimitStatus($limitChecks, $channelAccountId, [
                'stat_date'      => $statDate,
                'receipt_amount' => $receiptAmount,
                'receipt_count'  => $receiptCount,
                'payment_amount' => $paymentAmount,
                'payment_count'  => $paymentCount,
            ]);

        } catch (Throwable $e) {
            Log::error("计算历史限额状态失败", [
                'channel_account_id' => $channelAccountId,
                'stat_date'          => $statDate,
                'error'              => $e->getMessage()
            ]);
            return 2; // 发生错误时返回完全限额（安全考虑）
        }
    }

    /**
     * 根据限制检查结果确定限额状态
     */
    private function determineLimitStatus(array $limitChecks, int $channelAccountId, array $logData): int
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
            Log::info("渠道账户限额状态检查", array_merge([
                'channel_account_id' => $channelAccountId,
                'exceeded_checks'    => array_keys($exceededChecks),
                'total_checks'       => $totalChecks,
                'exceeded_count'     => $exceededCount
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
     * 获取指定日期的收款次数
     */
    private function getReceiptCountForDate(int $channelAccountId, string $statDate): int
    {
        return $this->collectionOrderRepository->getQuery()
            ->where('channel_account_id', $channelAccountId)
            ->whereDate('created_at', $statDate)
            ->count();
    }

    /**
     * 获取指定日期的付款次数
     */
    private function getPaymentCountForDate(int $channelAccountId, string $statDate): int
    {
        return $this->disbursementOrderRepository->getQuery()
            ->where('channel_account_id', $channelAccountId)
            ->whereDate('created_at', $statDate)
            ->count();
    }

    /**
     * 从缓存获取渠道账户配置
     */
    private function getChannelAccountFromCache(int $channelAccountId): ?object
    {
        if (!isset($this->channelAccountCache[$channelAccountId])) {
            $this->channelAccountCache[$channelAccountId] = $this->channelAccountRepository->findById($channelAccountId);
        }

        return $this->channelAccountCache[$channelAccountId];
    }
}
