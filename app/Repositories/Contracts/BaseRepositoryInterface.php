<?php

namespace App\Repositories\Contracts;


interface BaseRepositoryInterface
{

    public function getTableName(): string;

    public function create(array $data): \Illuminate\Database\Eloquent\Model|\Jenssegers\Mongodb\Eloquent\Model;

    public function createMany(array $data): bool;

    public function update(array $data, int|string $id): bool;

    public function updateOrCreate(array $data, array $condition): \Illuminate\Database\Eloquent\Model|\Jenssegers\Mongodb\Eloquent\Model;

    public function delete(int|string|array $id): int;

    public function deleteWhere(array $where): int;

    public function forceDelete(int|string $id): bool;

    public function forceDeleteWhere(array $where): int;

    public function restore(int|string $id): bool;

    public function restoreWhere(array $where): int;

    public function all(array $columns = array('*')): \Illuminate\Database\Eloquent\Collection;

    public function find(int|string $id, array $columns = ['*']): \Illuminate\Database\Eloquent\Model|null;

    public function findWithTrashed(int|string $id, array $columns = ['*']): \Illuminate\Database\Eloquent\Model|null;

    public function findFirst(array $where, array $columns = ['*']): \Illuminate\Database\Eloquent\Model|null;

    public function findFirstWithTrashed(array $where, array $columns = ['*']): \Illuminate\Database\Eloquent\Model|null;

    public function findByField(string $field, string $value, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    public function findWhere(array $where, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    public function findWhereWithTrashed(array $where, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    public function findWhereLimit(array $where, int $limit = 10, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    public function findWherePaginate(array $where, int $perPage = 20, array $columns = ['*'], string $pageName = null): \Illuminate\Pagination\LengthAwarePaginator;

    public function findWhereIn(string $field, array $values, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    public function findWhereNotIn(string $field, array $values, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    public function findWhereBetween(string $field, array $values, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    public function findWhereNotBetween(string $field, array $values, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    public function findOrderBy(array $where, string $order_field, string $order_direction = 'asc', array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    public function findOrderByFirst(array $where, string $order_field, string $order_direction = 'asc', array $columns = ['*']): \Illuminate\Database\Eloquent\Model|null;

    public function paginate(int $limit = null): \Illuminate\Pagination\LengthAwarePaginator;

}
