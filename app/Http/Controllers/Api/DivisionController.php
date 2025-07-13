<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Division\DivisionRequest;
use App\Services\DivisionService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class DivisionController extends Controller
{
    use ApiResponseTrait;

    protected $divisionService;

    public function __construct(DivisionService $divisionService)
    {
        $this->divisionService = $divisionService;
    }

    public function index(DivisionRequest $request): JsonResponse
    {
        try {
            $response = $this->divisionService->getAllDivisions($request);

            return $this->successResponse(
                data: ['divisions' => $response->transformedData],
                message: 'Data divisi berhasil diambil',
                paginator: $response->paginationData
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                message: 'Gagal mengambil data divisi',
                code: 500
            );
        }
    }
}
