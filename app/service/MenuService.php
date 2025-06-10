<?php

namespace app\service;

use app\model\ModelMenu;
use app\repository\MenuRepository;
use DI\Attribute\Inject;

/**
 * @extends IService<MenuRepository>
 */
class MenuService extends IService
{
    #[Inject]
    protected  MenuRepository $repository;


    public function create(array $data): ModelMenu
    {
        /**
         * @var ModelMenu $model
         */
        $model = parent::create($data);
        if ($data['meta']['type'] === 'M' && ! empty($data['btnPermission'])) {
            foreach ($data['btnPermission'] as $item) {
                $this->repository->create([
                    'parent_id' => $model->id,
                    'name' => $item['code'],
                    'sort' => 0,
                    'status' => 1,
                    'meta' => [
                        'title' => $item['title'],
                        'i18n' => $item['i18n'],
                        'type' => 'B',
                    ],
                ]);
            }
        }
        return $model;
    }

    public function updateById(mixed $id, array $data): mixed
    {
        $model = parent::updateById($id, $data);
        if ($model && $data['meta']['type'] === 'M' && ! empty($data['btnPermission'])) {
            foreach ($data['btnPermission'] as $item) {
                if (! empty($item['type']) && $item['type'] === 'B') {
                    $data = [
                        'name' => $item['code'],
                        'meta' => [
                            'title' => $item['title'],
                            'i18n' => $item['i18n'],
                            'type' => 'B',
                        ],
                    ];
                    if (! empty($item['id'])) {
                        $this->repository->updateById($item['id'], $data);
                    } else {
                        $data['parent_id'] = $id;
                        $this->repository->create($data);
                    }
                }
            }
        }
        return $model;
    }
}
