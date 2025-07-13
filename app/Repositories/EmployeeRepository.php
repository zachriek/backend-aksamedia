<?php

namespace App\Repositories;

use App\Http\Requests\Employee\GetEmployeeRequest;
use App\Models\Employee;

class EmployeeRepository extends BaseRepository
{
  protected $searchableFields = ['name'];
  protected $queryWith = ['division:id,name'];

  public function __construct(Employee $model)
  {
    parent::__construct($model);
  }

  public function getAllEmployeesWithPagination(GetEmployeeRequest $request)
  {
    return $this->getAllWithPagination($request, ['division_id' => $request->get('division_id')]);
  }
}
