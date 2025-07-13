<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponseTrait
{
  /**
   * Success response
   */
  protected function successResponse($data = null, $message = 'Success', $code = 200, $paginator = null): JsonResponse
  {
    $response = [
      'status' => 'success',
      'message' => $message,
    ];

    if ($data !== null) {
      $response['data'] = $data;
    }

    if ($paginator instanceof LengthAwarePaginator) {
      $response['pagination'] = [
        'current_page' => $paginator->currentPage(),
        'per_page' => $paginator->perPage(),
        'total' => $paginator->total(),
        'last_page' => $paginator->lastPage(),
        'from' => $paginator->firstItem(),
        'to' => $paginator->lastItem(),
        'has_more_pages' => $paginator->hasMorePages(),
        'prev_page_url' => $paginator->previousPageUrl(),
        'next_page_url' => $paginator->nextPageUrl(),
      ];
    }

    return response()->json($response, $code);
  }

  /**
   * Error response
   */
  protected function errorResponse($message, $code = 400, $data = null): JsonResponse
  {
    $response = [
      'status' => 'error',
      'message' => $message,
    ];

    if ($data !== null) {
      $response['data'] = $data;
    }

    return response()->json($response, $code);
  }

  /**
   * Validation error response
   */
  protected function validationErrorResponse($errors, $message = 'Validation failed'): JsonResponse
  {
    return response()->json([
      'status' => 'error',
      'message' => $message,
      'errors' => $errors,
    ], 422);
  }
}
