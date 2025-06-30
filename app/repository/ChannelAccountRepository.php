<?php

namespace app\repository;

use app\model\ModelChannelAccount;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ChannelAccountRepository.
 * @extends IRepository<ModelChannelAccount>
 */
final class ChannelAccountRepository extends IRepository
{
    #[Inject]
    protected ModelChannelAccount $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['channel_id']) && filled($params['channel_id'])) {
            $query->where('channel_id', $params['channel_id']);
        }

        if (isset($params['merchant_id']) && filled($params['merchant_id'])) {
            $query->where('merchant_id', $params['merchant_id']);
        }

        if (isset($params['limit_quota']) && filled($params['limit_quota'])) {
            $query->where('limit_quota', $params['limit_quota']);
        }

        if (isset($params['status']) && filled($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (isset($params['support_collection']) && filled($params['support_collection'])) {
            $query->where('support_collection', $params['support_collection']);
        }

        if (isset($params['support_disbursement']) && filled($params['support_disbursement'])) {
            $query->where('support_disbursement', $params['support_disbursement']);
        }

        return $query;
    }
}
