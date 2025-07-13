<?php

namespace App\Http\Middleware\Api;

use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    use ApiResponseTrait;

    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('sanctum')->check()) {
            return $this->errorResponse(
                message: 'Token tidak valid atau sudah expired. Silakan login kembali.',
                code: 401
            );
        }

        $user = auth('sanctum')->user();

        if (!$user) {
            return $this->errorResponse(
                message: 'User tidak ditemukan. Silakan login kembali.',
                code: 401
            );
        }

        $request->merge(['authenticated_user' => $user]);

        return $next($request);
    }
}
