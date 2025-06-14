<?php

namespace app\service;

use app\repository\SettingConfigGroupRepository;
use DI\Attribute\Inject;

/**
 * @extends IService<SettingConfigGroupRepository>
 */
class SettingConfigGroupService  extends IService
{
    #[Inject]
    protected SettingConfigGroupRepository $repository;
}
