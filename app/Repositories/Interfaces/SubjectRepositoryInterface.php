<?php

namespace App\Repositories\Interfaces;

interface SubjectRepositoryInterface
{
    public function getAllSubjects();
    public function createSubject(array $request);
    public function getSubjectById($subject);
    public function updateSubject(array $request, $subject);
    public function forceDeleteSubject($subject);
}
