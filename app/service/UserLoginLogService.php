<?php

namespace app\service;

use app\repository\UserLoginLogRepository;
use DI\Attribute\Inject;

/**
 * @extends IService<UserLoginLogRepository>
 */
final class UserLoginLogService extends IService
{
    #[Inject]
    protected UserLoginLogRepository $repository;

}
