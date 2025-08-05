<?php

namespace app\service;

use app\constants\DisbursementOrder;
use app\exception\BusinessException;
use app\exception\OpenApiException;
use app\lib\enum\ResultCode;
use app\model\ModelTenantApp;
use app\repository\DisbursementOrderRepository;
use app\repository\TenantRepository;
use DI\Attribute\Inject;
use support\Context;
use Webman\Http\Request;

final class DisbursementOrderService extends IService
{
    #[Inject]
    public DisbursementOrderRepository $repository;
    #[Inject]
    protected TenantRepository $tenantRepository;

    // 创建订单
    public function createOrder(array $data, string $source = ''): array
    {
        // 查询租户获取配置
        $findTenant = $this->tenantRepository->getQuery()->where('tenant_id', $data['tenant_id'])->first();
        $request = Context::get(Request::class);
        $app = Context::get(ModelTenantApp::class);
        // test 调试使用
        if (!$app) {
            $app = ModelTenantApp::getQuery()->where('app_key', $data['app_key'])->first();
        }
        // 计算收款费率
        $calculate = [
            'fixed_fee' => $findTenant->receipt_fixed_fee,
            'rate_fee'  => $findTenant->receipt_fee_rate,
        ];
        $rate_fee = bcdiv($findTenant->receipt_fee_rate, '100', 4);
        $rate_fee_amount = bcmul($data['amount'], $rate_fee, 4);
        $calculate['rate_fee_amount'] = $rate_fee_amount;
        $calculate['total_fee'] = bcadd($calculate['fixed_fee'], $rate_fee_amount, 4);
        $disbursementOrder = $this->repository->create([
            'tenant_id'          => $data['tenant_id'],
            'tenant_order_no'    => $data['tenant_order_no'],
            'amount'             => $data['amount'],
            'order_source'       => $source,
            'notify_remark'      => $data['notify_remark'] ?? '',
            'notify_url'         => $data['notify_url'] ?? '',
            'fixed_fee'          => $calculate['fixed_fee'],
            'rate_fee'           => $calculate['rate_fee'],
            'rate_fee_amount'    => $calculate['rate_fee_amount'],
            'total_fee'          => $calculate['total_fee'],
            'settlement_amount'  => bcadd($data['amount'], $calculate['total_fee'], 4),
            'payment_type'       => $data['payment_type'],
            'payee_bank_name'    => $data['payee_bank_name'] ?? '',
            'payee_bank_code'    => $data['payee_bank_code'] ?? '',
            'payee_account_name' => $data['payee_account_name'] ?? '',
            'payee_account_no'   => $data['payee_account_no'] ?? '',
            'payee_phone'        => $data['payee_phone'] ?? '',
            'payee_upi'          => $data['payee_upi'] ?? '',
            'app_id'             => $app->id ?? '',
            'status'             => DisbursementOrder::STATUS_WAIT_PAY,
            'request_id'         => $request->requestId,
        ]);
        if (!filled($disbursementOrder)) {
            throw new BusinessException(ResultCode::ORDER_CREATE_FAILED);
        }
        return [
            'platform_order_no' => $disbursementOrder->platform_order_no,
            'tenant_order_no'   => $disbursementOrder->tenant_order_no,
            'amount'            => $disbursementOrder->amount,
            'status'            => $disbursementOrder->status,
        ];
    }
}
