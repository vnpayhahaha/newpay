<?php

namespace app\service;

use app\repository\ChannelAccountDailyStatsRepository;
use DI\Attribute\Inject;

final class ChannelAccountDailyStatsService extends IService
{
    #[Inject]
    public ChannelAccountDailyStatsRepository $repository;
}
