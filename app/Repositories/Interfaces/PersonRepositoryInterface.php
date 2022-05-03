<?php

namespace App\Repositories\Interfaces;

interface PersonRepositoryInterface
{
    public function getAllPeople();
    public function createPerson(array $request);
    public function getPersonById($person);
    public function updatePerson(array $request, $person);
    public function forceDeletePerson($person);
}
