<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->getUser($request);

            if (!$user || !$this->authService->comparePassword($request->password, $user->password)) {
                return $this->errorResponse(
                    message: 'Username atau password salah',
                    code: 401
                );
            }

            $token = $this->authService->createToken($user);

            return $this->successResponse(
                data: [
                    'token' => $token,
                    'admin' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'phone' => $user->phone,
                        'email' => $user->email,
                    ]
                ],
                message: 'Login berhasil'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                message: 'Terjadi kesalahan pada server',
                code: 500
            );
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authService->deleteAccessToken();
            return $this->successResponse(message: 'Logout berhasil');
        } catch (\Exception $e) {
            return $this->errorResponse(
                message: 'Terjadi kesalahan pada server',
                code: 500
            );
        }
    }
}
