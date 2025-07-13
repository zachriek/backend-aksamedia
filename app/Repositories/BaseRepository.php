<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
  protected $model;
  protected $perPage = 10;
  protected $searchableFields = [];
  protected $queryWith = null;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function getAllWithPagination($request, $filters = [])
  {
    $query = $this->model->newQuery();

    if ($this->queryWith) {
      $query->with($this->queryWith);
    }

    if ($search = $request->get('name')) {
      $query = $this->applySearch($query, $search);
    }

    foreach ($filters as $key => $value) {
      if ($value !== null) {
        $query->where($key, $value);
      }
    }

    $query->orderBy('created_at', 'desc');

    $perPage = $request->get('per_page', $this->perPage);

    return $query->paginate($perPage);
  }

  protected function applySearch($query, $search)
  {
    if (method_exists($this->model, 'scopeSearch')) {
      return $query->search($search);
    }

    if (!empty($this->searchableFields)) {
      $query->where(function ($q) use ($search) {
        foreach ($this->searchableFields as $field) {
          $q->orWhere($field, 'LIKE', "%{$search}%");
        }
      });
    }

    return $query;
  }

  public function findById($id)
  {
    $query = $this->model->newQuery();

    if ($this->queryWith) {
      $query->with($this->queryWith);
    }

    return $query->findOrFail($id);
  }

  public function create(array $data)
  {
    return $this->model->create($data);
  }

  public function update($id, array $data)
  {
    $record = $this->findById($id);
    $record->update($data);
    return $record;
  }

  public function delete($id)
  {
    $record = $this->findById($id);
    return $record->delete();
  }
}
