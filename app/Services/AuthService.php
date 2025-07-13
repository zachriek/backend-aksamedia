<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{
  protected $authRepository;

  public function __construct(AuthRepository $authRepository)
  {
    $this->authRepository = $authRepository;
  }

  public function getUser(LoginRequest $request)
  {
    $user = $this->authRepository->getUserByUsername($request);
    return $user;
  }

  public function createToken(User $user)
  {
    $token = $user->createToken('auth_token')->plainTextToken;
    return $token;
  }

  public function comparePassword($password, $hashedPassword)
  {
    return Hash::check($password, $hashedPassword);
  }

  public function getAuthenticatedUser(Request $request)
  {
    return $request->get('authenticated_user');
  }

  public function deleteAccessToken()
  {
    auth()->user()->currentAccessToken()->delete();
  }
}
