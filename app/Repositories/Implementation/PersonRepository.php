<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\PersonRepositoryInterface;

class PersonRepository implements PersonRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getAllPeople()
    {
        // TODO: Implement getAllPeople() method.
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function createPerson(array $request)
    {
        // TODO: Implement createPerson() method.
    }

    /**
     * @param $person
     * @return mixed
     */
    public function getPersonById($person)
    {
        // TODO: Implement getPersonById() method.
    }

    /**
     * @param array $request
     * @param $person
     * @return mixed
     */
    public function updatePerson(array $request, $person)
    {
        // TODO: Implement updatePerson() method.
    }

    /**
     * @param $person
     * @return mixed
     */
    public function forceDeletePerson($person)
    {
        // TODO: Implement forceDeletePerson() method.
    }
}
