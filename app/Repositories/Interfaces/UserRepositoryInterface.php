<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function createUser(array $request);
    public function getUserById($user);
    public function updateUser(array $request, $user);
    public function forceDeleteUser($user);
}
