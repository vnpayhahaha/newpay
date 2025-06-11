<?php

namespace app\repository;

use app\model\ModelSystemConfig;
use DI\Attribute\Inject;

/**
 * Class UserRepository.
 * @extends IRepository<ModelSystemConfig>
 */
final class SystemConfigRepository extends IRepository
{
    #[Inject]
    protected  ModelSystemConfig $model;
}
