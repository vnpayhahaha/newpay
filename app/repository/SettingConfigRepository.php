<?php

namespace app\repository;

use app\model\ModelSettingConfig;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class SettingConfigRepository.
 * @extends IRepository<ModelSettingConfig>
 */
final class SettingConfigRepository extends IRepository
{
    #[Inject]
    protected ModelSettingConfig $model;

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (isset($params['group_id'])) {
            $query->where('group_id', '=', $params['group_id']);
        }

        if (isset($params['key'])) {
            $query->where('key', '=', $params['key']);
        }

        if (isset($params['value'])) {
            $query->where('value', '=', $params['value']);
        }

        if (isset($params['name'])) {
            $query->where('name', '=', $params['name']);
        }

        if (isset($params['input_type'])) {
            $query->where('input_type', '=', $params['input_type']);
        }

        if (isset($params['config_select_data'])) {
            $query->where('config_select_data', '=', $params['config_select_data']);
        }

        if (isset($params['sort'])) {
            $query->where('sort', '=', $params['sort']);
        }

        if (isset($params['remark'])) {
            $query->where('remark', '=', $params['remark']);
        }

        return $query;
    }

    /**
     * 按Key获取配置.
     */
    public function getConfigByKey(string $key): array
    {
        $model = $this->model::query()->select([
            'group_id', 'name', 'key', 'value', 'sort', 'input_type', 'config_select_data',
        ])->where('key', '=', $key)->first();
        return $model ? $model->toArray() : [];
    }

}
