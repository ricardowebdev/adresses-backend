<?php

namespace App\Repositories;

abstract class BaseRepository
{
    const DEFAULT_PAGINATOR_LIMIT = 20;

    protected \Illuminate\Database\Eloquent\Model|string $_model;

    public function __construct()
    {
        $this->_model = $this->resolveModel();
    }

    protected function resolveModel(){
        return app($this->_model);
    }

    public function getTableName(): string
    {
        return $this->_model->getTable();
    }

    public function create(array $data): \Illuminate\Database\Eloquent\Model
    {
        return $this->_model->create($data);
    }

    public function createMany(array $data): bool
    {
        return $this->_model->insert($data);
    }

    public function update(array $data, int|string $id): bool
    {
        return $this->_model->find($id)->update($data);
    }

    public function updateOrCreate(array $data, array $condition): \Illuminate\Database\Eloquent\Model
    {
        return $this->_model->updateOrCreate($condition, $data);
    }

    public function delete(int|string|array $id): int
    {
        return $this->_model->destroy($id);
    }

    public function deleteWhere(array $where): int
    {
        $find = (is_array($where[0]) ? $where : [$where]);
        return $this->_model->where($find)->delete();
    }

    public function forceDelete(int|string $id): bool
    {
        return $this->_model->withTrashed()->find($id)->forceDelete();
    }

    public function forceDeleteWhere(array $where): int
    {
        $find = (is_array($where[0]) ? $where : [$where]);
        return $this->_model->withTrashed()->where($find)->forceDelete();
    }

    public function restore(int|string $id): bool
    {
        return $this->_model->onlyTrashed()->find($id)->restore();
    }

    public function restoreWhere(array $where): int
    {
        $find = (is_array($where[0]) ? $where : [$where]);
        return $this->_model->onlyTrashed()->where($find)->restore();
    }

    public function all(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return $this->_model->select($columns)->get();
    }

    public function find(int|string $id, array $columns = ['*']): \Illuminate\Database\Eloquent\Model|null
    {
        return $this->_model->select($columns)->find($id);
    }

    public function findWithTrashed(int|string $id, array $columns = ['*']): \Illuminate\Database\Eloquent\Model|null
    {
        return $this->_model->withTrashed()->select($columns)->find($id);
    }

    public function findFirst(array $where, array $columns = ['*']): \Illuminate\Database\Eloquent\Model|null
    {
        $find = (is_array($where[0]) ? $where : [$where]);
        return $this->_model->select($columns)->where($find)->limit(1)->get()->first();
    }

    public function findFirstWithTrashed(array $where, array $columns = ['*']): \Illuminate\Database\Eloquent\Model|null
    {
        $find = (is_array($where[0]) ? $where : [$where]);
        return $this->_model->withTrashed()->select($columns)->where($find)->limit(1)->get()->first();
    }

    public function findByField(string $field, string $value, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return $this->_model->select($columns)->where($field, $value)->get();
    }

    public function findWhere(array $where, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        $find = (is_array($where[0]) ? $where : [$where]);
        return $this->_model->select($columns)->where($find)->get();
    }

    public function findWhereWithTrashed(array $where, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        $find = (is_array($where[0]) ? $where : [$where]);
        return $this->_model->withTrashed()->select($columns)->where($find)->get();
    }

    public function findWhereLimit(array $where, int $limit = 10, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        $find = (is_array($where[0]) ? $where : [$where]);
        return $this->_model->select($columns)->where($find)->limit($limit)->get();
    }

    public function findWherePaginate(array $where, int $perPage = self::DEFAULT_PAGINATOR_LIMIT, array $columns = ['*'], string $pageName = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        $find = (is_array($where[0]) ? $where : [$where]);
        return $this->_model->where($find)->paginate($perPage, $columns, $pageName);
    }

    public function findWhereIn(string $field, array $values, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return $this->_model->select($columns)->whereIn($field, $values)->get();
    }

    public function findWhereNotIn(string $field, array $values, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return $this->_model->select($columns)->whereNotIn($field, $values)->get();
    }

    public function findWhereBetween(string $field, array $values, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return $this->_model->select($columns)->whereBetween($field, $values)->get();
    }

    public function findWhereNotBetween(string $field, array $values, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return $this->_model->select($columns)->whereNotBetween($field, $values)->get();
    }

    public function findOrderBy(array $where, string $order_field, string $order_direction = 'asc', array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        $find = (is_array($where[0]) ? $where : [$where]);
        return $this->_model->select($columns)->where($find)->orderBy($order_field, $order_direction)->get();
    }

    public function findOrderByFirst(array $where, string $order_field, string $order_direction = 'asc', array $columns = ['*']): \Illuminate\Database\Eloquent\Model|null
    {
        $find = (is_array($where[0]) ? $where : [$where]);
        return $this->_model->select($columns)->where($find)->orderBy($order_field, $order_direction)->limit(1)->get()->first();
    }

    public function paginate(int $limit = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        $pg = (is_null($limit) ? self::DEFAULT_PAGINATOR_LIMIT : $limit);
        return $this->_model->paginate($pg);
    }

}
