<?php

namespace App\Repositories\Interfaces;

interface MarkRepositoryInterface
{
    public function getAllMarks();
    public function createMark(array $request);
    public function getMarkById($mark);
    public function updateMark(array $request, $mark);
    public function forceDeleteMark($mark);
}
