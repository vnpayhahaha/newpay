<?php

namespace app\repository;


use app\model\ModelChannelAccountDailyStats;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ChannelAccountDailyStatsRepository.
 * @extends IRepository<ModelChannelAccountDailyStats>
 */
final class ChannelAccountDailyStatsRepository extends IRepository
{
    #[Inject]
    protected ModelChannelAccountDailyStats $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['channel_account_id'])) {
            $query->where('channel_account_id', $params['channel_account_id']);
        }

        if (isset($params['bank_account_id'])) {
            $query->where('bank_account_id', $params['bank_account_id']);
        }

        if (isset($params['channel_id'])) {
            $query->where('channel_id', $params['channel_id']);
        }

        if (isset($params['stat_date'])) {
            $query->where('stat_date', $params['stat_date']);
        }

        if (isset($params['success_rate'])) {
            $query->where('success_rate', $params['success_rate']);
        }

        if (isset($params['limit_status'])) {
            $query->where('limit_status', $params['limit_status']);
        }

        if (isset($params['created_at'])) {
            $query->where('created_at', $params['created_at']);
        }

        return $query;
    }
}
