<?php

namespace app\service;

use app\repository\TenantAppRepository;
use DI\Attribute\Inject;
use Exception;

/**
 * @extends IService<TenantAppRepository>
 */
final class TenantAppService extends IService
{
    #[Inject]
    protected TenantAppRepository $repository;

    /**
     * 生成新的app key.
     * @throws Exception
     */
    public function getAppKey(): string
    {
        return bin2hex(random_bytes(5));
    }

    /**
     * 生成新的app secret.
     * @throws Exception
     */
    public function getAppSecret(): string
    {
        return base64_encode(bin2hex(random_bytes(32)));
    }

}
