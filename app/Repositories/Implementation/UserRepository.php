<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getAllUsers()
    {
        // TODO: Implement getAllUsers() method.
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function createUser(array $request)
    {
        // TODO: Implement createUser() method.
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getUserById($user)
    {
        // TODO: Implement getUserById() method.
    }

    /**
     * @param array $request
     * @param $user
     * @return mixed
     */
    public function updateUser(array $request, $user)
    {
        // TODO: Implement updateUser() method.
    }

    /**
     * @param $user
     * @return mixed
     */
    public function forceDeleteUser($user)
    {
        // TODO: Implement forceDeleteUser() method.
    }
}
