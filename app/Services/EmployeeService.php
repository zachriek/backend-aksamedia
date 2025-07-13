<?php

namespace App\Services;

use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\GetEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Repositories\EmployeeRepository;

class EmployeeService
{
  protected $employeeRepository;
  protected $imageUploadService;

  public function __construct(EmployeeRepository $employeeRepository, ImageUploadService $imageUploadService)
  {
    $this->employeeRepository = $employeeRepository;
    $this->imageUploadService = $imageUploadService;
  }

  public function getAllEmployees(GetEmployeeRequest $request)
  {
    $employees = $this->employeeRepository->getAllEmployeesWithPagination($request);

    $transformedEmployees = $this->transformEmployeesCollection($employees->getCollection());

    return (object) [
      'transformedData' => $transformedEmployees,
      'paginationData' => $employees,
    ];
  }

  public function getEmployee(string $id)
  {
    $employee = $this->employeeRepository->findById($id);

    $transformedEmployee = $this->transformEmployeeData($employee);

    return (object) [
      'transformedData' => $transformedEmployee,
    ];
  }

  public function createEmployee(CreateEmployeeRequest $request)
  {
    $data = $request->validated();
    $data['division_id'] = $request->get('division');

    if ($request->hasFile('image')) {
      $imageFile = $request->file('image');

      $data['image'] = $this->imageUploadService->uploadImage($imageFile);
    }


    $this->employeeRepository->create($data);
  }

  public function updateEmployee(UpdateEmployeeRequest $request, string $id)
  {
    $data = $request->validated();
    $data['division_id'] = $request->get('division');

    if ($request->hasFile('image')) {
      $imageFile = $request->file('image');

      $data['image'] = $this->imageUploadService->uploadImage($imageFile);
    }

    $this->employeeRepository->update($id, $data);
  }

  public function deleteEmployee(string $id)
  {
    $employee = $this->employeeRepository->findById($id);

    if ($employee->image !== null) {
      $this->imageUploadService->deleteImage($employee->image);
    }

    $this->employeeRepository->delete($id);
  }

  public function transformEmployeeData($employee)
  {
    return [
      'id' => $employee->id,
      'image' => $employee->image,
      'name' => $employee->name,
      'phone' => $employee->phone,
      'division' => [
        'id' => $employee->division->id,
        'name' => $employee->division->name,
      ],
      'position' => $employee->position,
    ];
  }

  public function transformEmployeesCollection($employees)
  {
    return $employees->map(function ($employee) {
      return $this->transformEmployeeData($employee);
    });
  }
}
