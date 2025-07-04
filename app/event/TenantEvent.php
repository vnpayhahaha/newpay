<?php

namespace app\event;

use app\constants\TenantAccount;
use app\model\ModelTenant;
use app\model\ModelTenantAccount;
use support\Container;

class TenantEvent
{
    public function Created(ModelTenant $model): void
    {
        $accountModel = Container::make(ModelTenantAccount::class);
        var_dump('TenantCreated  event==', $model);
        $insertAccount = $accountModel->insert([
            [
                'tenant_id'         => $model->tenant_id,
                'account_id'        => TenantAccount::ACCOUNT_ID_PREFIX_RECEIVE . $model->tenant_id,
                'balance_available' => 0,
                'balance_frozen'    => 0,
                'account_type'      => TenantAccount::ACCOUNT_TYPE_RECEIVE,
                'version'           => 1,
            ],
            [
                'tenant_id'         => $model->tenant_id,
                'account_id'        => TenantAccount::ACCOUNT_ID_PREFIX_PAY . $model->tenant_id,
                'balance_available' => 0,
                'balance_frozen'    => 0,
                'account_type'      => TenantAccount::ACCOUNT_TYPE_PAY,
                'version'           => 1,
            ]
        ]);

        var_dump('insertAccount==', $insertAccount);
    }

}
