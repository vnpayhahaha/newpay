<?php

namespace app\repository;

use app\repository\Traits\BootTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @template T of Model
 * @property T $model
 */
abstract class IRepository
{
    use BootTrait;

    public const PER_PAGE_PARAM_NAME = 'per_page';

    public function handleSearch(Builder $query, array $params): Builder
    {
        return $query;
    }

    public function handleItems(Collection $items): Collection
    {
        return $items;
    }

    public function getQuery(): Builder
    {
        return $this->model->newQuery();
    }

    public function perQuery(Builder $query, array $params): Builder
    {
        $query = ($params['recycle'] ?? false) && $this->model->getDeletedAtColumn() ? $query->onlyTrashed() : $query;
        $this->startBoot($query, $params);
        return $this->handleSearch($query, $params);
    }

    public function list(array $params = []): Collection
    {
        return $this->perQuery($this->getQuery(), $params)->get();
    }

    public function count(array $params = []): int
    {
        return $this->perQuery($this->getQuery(), $params)->count();
    }

    // Error: Class "Illuminate\Pagination\Paginator

    #[ArrayShape(['list' => "mixed", 'total' => "int"])]
    public function handlePage(\Illuminate\Pagination\LengthAwarePaginator $paginator): array
    {
        $items = Collection::make($paginator->items());
        return [
            'list'  => $items->toArray(),
            'total' => $paginator->total(),
        ];
    }

    public function page(array $params = [], ?int $page = null, ?int $pageSize = null): array
    {
        $result = $this->perQuery($this->getQuery(), $params)->paginate(
            perPage: $pageSize,
            pageName: static::PER_PAGE_PARAM_NAME,
            page: $page,
        );
        return $this->handlePage($result);
    }

    /**
     * @return T
     */
    public function create(array $data): mixed
    {
        // @phpstan-ignore-next-line
        return $this->getQuery()->create($data);
    }

    public function deleteById(mixed $id): int
    {
        // @phpstan-ignore-next-line
        return $this->model::destroy($id);
    }

    /**
     * @return null|T
     */
    public function findByFilter(array $params): mixed
    {
        return $this->perQuery($this->getQuery(), $params)->first();
    }

    /**
     * @return T
     */
    public function getModel()
    {
        return $this->model;
    }

    public function updateById(mixed $id, array $data): bool
    {
        return (bool)$this->getQuery()->whereKey($id)->first()?->update($data);
    }

    /**
     * @return null|T
     */
    public function findById(mixed $id): mixed
    {
        return $this->getQuery()->whereKey($id)->first();
    }

    public function existsById(mixed $id): bool
    {
        return (bool)$this->getQuery()->whereKey($id)->exists();
    }
}
