<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository extends BaseRepository
{
  public function __construct(User $model)
  {
    parent::__construct($model);
  }

  /**
   * Get user by username
   */
  public function getUserByUsername($request)
  {
    return $this->model->where('username', $request->username)->first();
  }
}
