<?php

namespace App\Services;

use App\Http\Requests\Division\DivisionRequest;
use App\Repositories\DivisionRepository;

class DivisionService
{
  protected $divisionRepository;

  public function __construct(DivisionRepository $divisionRepository)
  {
    $this->divisionRepository = $divisionRepository;
  }

  public function getAllDivisions(DivisionRequest $request)
  {
    $divisions = $this->divisionRepository->getActiveDivisions($request);

    $transformedData = $this->transformDivisionsCollection($divisions->getCollection());

    return (object) [
      'transformedData' => $transformedData,
      'paginationData' => $divisions,
    ];
  }

  public function transformDivisionData($division)
  {
    return [
      'id' => $division->id,
      'name' => $division->name,
    ];
  }

  public function transformDivisionsCollection($divisions)
  {
    return $divisions->map(function ($division) {
      return $this->transformDivisionData($division);
    });
  }
}
