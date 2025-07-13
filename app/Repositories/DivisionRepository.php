<?php

namespace App\Repositories;

use App\Http\Requests\Division\DivisionRequest;
use App\Models\Division;

class DivisionRepository extends BaseRepository
{
  protected $searchableFields = ['name'];

  public function __construct(Division $model)
  {
    parent::__construct($model);
  }

  public function getActiveDivisions(DivisionRequest $request)
  {
    return $this->getAllWithPagination($request, ['is_active' => true]);
  }
}
