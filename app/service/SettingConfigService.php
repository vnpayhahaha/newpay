<?php

namespace app\service;

use app\repository\SettingConfigRepository;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Collection;

/**
 * @extends IService<SettingConfigRepository>
 */
class SettingConfigService extends IService
{
    #[Inject]
    protected SettingConfigRepository $repository;

    // 查询数据
    public function getDetails($params): Collection
    {
        // 获取查询构建器
        $query = $this->repository->getQuery();
        $query->where($params);
        $query->orderBy('created_at', 'desc');
        return $query->get();  // 执行查询并返回结果
    }

    // 根据key删除数据
    public function deleteByKey($data): bool
    {
        // 获取传递进来的 key
        $key = $data['key'] ?? null; // 使用 ?? 来确保如果没有 key 字段，$key 为 null

        if ($key) {
            $deleted = $this->repository->getModel()->where('key', $key)->delete();
            return $deleted > 0;
        }
        return false; // 如果没有 key 字段，返回 false
    }

    /**
     * 写入数据，使用 updateOrCreate 处理.
     */
    public function upsertData(array $param): void
    {
        $model = $this->repository->getModel();
        foreach ($param as $params) {
            // 仅处理checkbox类型的value字段
            if ($params['input_type'] === 'checkbox' && \is_array($params['value'])) {
                $params['value'] = implode(',', $params['value']);
            }
            // 执行更新或插入操作
            $model->getModel()->updateOrCreate(
                [
                    'group_id' => $params['group_id'],
                    'key'      => $params['key'],
                ],
                $params
            );
        }
    }
}
