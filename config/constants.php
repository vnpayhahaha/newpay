<?php

return [
    'menu'            => app\constants\Menu::class, // 菜单状态
    'policy'          => app\constants\Policy::class, // 策略状态
    'role'            => app\constants\Role::class, // 角色状态
    'user'            => app\constants\User::class, // 用户状态
    'tenant'          => app\constants\Tenant::class, // 租户状态
    'tenant_app'      => app\constants\TenantApp::class, // 租户应用状态
    'tenant_user'     => app\constants\TenantUser::class, // 租户用户状态
    'tenant_config'   => app\constants\TenantConfig::class, // 租户配置状态
    'channel'         => app\constants\Channel::class, // 渠道状态
    'channel_account' => app\constants\ChannelAccount::class, // 渠道账户状态
    'bank_account'    => app\constants\BankAccount::class, // 银行账户状态
    'tenant_account'  => app\constants\TenantAccount::class, // 租户账户状态
];
