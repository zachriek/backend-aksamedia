<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\GetEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Services\EmployeeService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    use ApiResponseTrait;

    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index(GetEmployeeRequest $request): JsonResponse
    {
        try {
            $response = $this->employeeService->getAllEmployees($request);

            return $this->successResponse(
                data: ['employees' => $response->transformedData],
                message: 'Data karyawan berhasil diambil',
                paginator: $response->paginationData
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                message: 'Terjadi kesalahan saat mengambil data karyawan: ' . $e->getMessage(),
                code: 500
            );
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $response = $this->employeeService->getEmployee($id);

            return $this->successResponse(
                data: ['employee' => $response->transformedData],
                message: 'Data karyawan berhasil diambil'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                message: 'Terjadi kesalahan saat mengambil data karyawan: ' . $e->getMessage(),
                code: 500
            );
        }
    }

    public function store(CreateEmployeeRequest $request): JsonResponse
    {
        try {
            $this->employeeService->createEmployee($request);

            return $this->successResponse(
                message: 'Data karyawan berhasil ditambahkan',
                code: 201
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                message: 'Terjadi kesalahan saat menambah data karyawan: ' . $e->getMessage(),
                code: 500
            );
        }
    }

    public function update(UpdateEmployeeRequest $request, string $id): JsonResponse
    {
        try {
            $this->employeeService->updateEmployee($request, $id);

            return $this->successResponse(
                message: 'Data karyawan berhasil diperbarui',
                code: 200
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                message: 'Terjadi kesalahan saat memperbarui data karyawan: ' . $e->getMessage(),
                code: 500
            );
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->employeeService->deleteEmployee($id);

            return $this->successResponse(
                message: 'Data karyawan berhasil dihapus',
                code: 200
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                message: 'Terjadi kesalahan saat menghapus data karyawan: ' . $e->getMessage(),
                code: 500
            );
        }
    }
}
