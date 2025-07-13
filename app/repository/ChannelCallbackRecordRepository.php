<?php

namespace app\repository;

use app\model\ModelChannelCallbackRecord;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ChannelCallbackRecordRepository.
 * @extends IRepository<ModelChannelCallbackRecord>
 */
final class ChannelCallbackRecordRepository extends IRepository
{
    #[Inject]
    protected ModelChannelCallbackRecord $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['callback_id'])) {
            $query->where('callback_id', $params['callback_id']);
        }

        if (isset($params['channel_id'])) {
            $query->where('channel_id', $params['channel_id']);
        }

        if (isset($params['original_request_id'])) {
            $query->where('original_request_id', $params['original_request_id']);
        }

        if (isset($params['callback_type'])) {
            $query->where('callback_type', $params['callback_type']);
        }

        if (isset($params['callback_body'])) {
            $query->where('callback_body', $params['callback_body']);
        }

        if (isset($params['verification_status'])) {
            $query->where('verification_status', $params['verification_status']);
        }

        return $query;
    }
}
