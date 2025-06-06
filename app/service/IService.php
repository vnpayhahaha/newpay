<?php

namespace app\service;

use app\lib\traits\HasContainer;
use app\repository\IRepository;
use Illuminate\Support\Collection;

/**
 * @template T of Model
 * @property IRepository<T> $repository
 */
abstract class IService
{
    public function count(array $params): int
    {
        return $this->repository->count($params);
    }

    public function page(array $params, int $page = 1, int $pageSize = 10): array
    {
        return $this->repository->page($params, $page, $pageSize);
    }

    public function getList(array $paras): Collection
    {
        return $this->repository->list($paras);
    }

    /**
     * @return T
     */
    public function create(array $data): mixed
    {
        return $this->repository->create($data);
    }

    /**
     * @return T
     */
    public function save(array $data): mixed
    {
        return $this->create($data);
    }
}
