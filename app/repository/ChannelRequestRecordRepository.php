<?php

namespace app\repository;

use app\model\ModelChannelRequestRecord;
use DI\Attribute\Inject;

/**
 * Class ChannelRequestRecordRepository.
 * @extends IRepository<ModelChannelRequestRecord>
 */
final class ChannelRequestRecordRepository extends IRepository
{
    #[Inject]
    protected ModelChannelRequestRecord$model;
}
