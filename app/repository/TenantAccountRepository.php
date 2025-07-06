<?php

namespace app\repository;

use app\model\enums\TenantAccountRecordChangeType;
use app\model\ModelTenantAccount;
use app\model\ModelTenantAccountRecord;
use Carbon\Carbon;
use DI\Attribute\Inject;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use support\Db;

/**
 * Class TenantAccountRepository.
 * @extends IRepository<ModelTenantAccount>
 */
class TenantAccountRepository extends IRepository
{
    #[Inject]
    protected ModelTenantAccount       $model;
    #[Inject]
    protected ModelTenantAccountRecord $modelTenantAccountRecord;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['tenant_id']) && filled($params['tenant_id'])) {
            $query->where('tenant_id', $params['tenant_id']);
        }

        if (isset($params['account_id']) && filled($params['account_id'])) {
            $query->where('account_id', $params['account_id']);
        }

        if (isset($params['account_type']) && filled($params['account_type'])) {
            $query->where('account_type', $params['account_type']);
        }

        return $query;
    }

    public function page(array $params = [], ?int $page = null, ?int $pageSize = null): array
    {
        $result = $this->perQuery($this->getQuery(), $params)->with('tenant:tenant_id,company_name')->paginate(
            perPage: $pageSize,
            pageName: static::PER_PAGE_PARAM_NAME,
            page: $page,
        );
        return $this->handlePage($result);
    }


    private function updateBalanceWithLock(int $id, string $field, float $amount, TenantAccountRecordChangeType $changeType, string $transactionNo = ''): bool
    {
        $maxRetries = 3;
        $retryInterval = 100; // 毫秒
        $retries = 0;

        while ($retries < $maxRetries) {
            try {
                return Db::transaction(function () use ($id, $field, $amount, $changeType, $transactionNo) {
                    // 获取当前账户信息
                    $account = $this->model::query()->where('id', $id)->first();
                    if (!$account) {
                        throw new Exception("Account[ID:{$id}] not found", 404);
                    }

                    $oldBalance = $account[$field];
                    $version = $account['version'];
                    $newBalance = bcadd((string)$oldBalance, (string)$amount, 4);
                    var_dump('bccomp：',bccomp($newBalance, '0'));
                    if (bccomp($newBalance, '0') < 0) {
                        var_dump('减款 余额不足 失败 failed');
                        // 减款 余额不足 失败 failed
                        throw new \Exception('Insufficient balance', 1000);
                    }
                    $nowTime = date('Y-m-d H:i:s');

                    // 构建变更日志数据
                    $logData = [
                        'tenant_id'                => $account['tenant_id'],
                        'tenant_account_id'        => $id,
                        'account_type'             => $account['account_type'],
                        'change_amount'            => $amount,
                        'balance_available_before' => $account['balance_available'],
                        'balance_available_after'  => $account['balance_available'],
                        'balance_frozen_before'    => $account['balance_frozen'],
                        'balance_frozen_after'     => $account['balance_frozen'],
                        'change_type'              => $changeType,
                        'transaction_no'           => $transactionNo,
                        'created_at'               => $nowTime
                    ];

                    // 动态设置变更字段
                    $logData["{$field}_before"] = $oldBalance;
                    $logData["{$field}_after"] = $newBalance;

                    // 插入变更日志
                    $this->modelTenantAccountRecord::query()->insert($logData);

                    // 执行乐观锁更新
                    $updateResult = $this->model->newQuery()
                        ->where('id', $id)
                        ->where('version', $version)
                        ->update([
                            $field       => $newBalance,
                            'version'    => $version + 1,
                            'updated_at' => $nowTime
                        ]);

                    if ($updateResult === 0) {
                        throw new Exception("Concurrent modification detected", 409);
                    }

                    return true;
                });
            } catch (Exception $e) {
                if ($e->getCode() === 409) {
                    $retries++;
                    usleep($retryInterval * 1000); // 转换为微秒
                    continue;
                }
                var_dump('changeTenantAccount err:', $e->getMessage());
                throw $e;
            }
        }
        throw new Exception("Max retries exceeded", 500);
    }

    // 更新balance_available by id

    /**
     * @param int $id
     * @param float $amount
     * @param TenantAccountRecordChangeType $changeType
     * @param string $transactionNo
     * @return bool
     * @throws Exception
     */
    public function updateBalanceAvailableById(int $id, float $amount, TenantAccountRecordChangeType $changeType, string $transactionNo = ''): bool
    {
        return $this->updateBalanceWithLock($id, 'balance_available', $amount, $changeType, $transactionNo);
    }

    // 更新balance_frozen by id

    /**
     * @param int $id
     * @param float $amount
     * @param TenantAccountRecordChangeType $changeType
     * @param string $transactionNo
     * @return bool
     * @throws Exception
     */
    public function updateBalanceFrozenById(int $id, float $amount, TenantAccountRecordChangeType $changeType, string $transactionNo = ''): bool
    {
        return $this->updateBalanceWithLock($id, 'balance_frozen', $amount, $changeType, $transactionNo);
    }
}
