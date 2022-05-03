<?php

namespace App\Repositories\Interfaces;

interface ExamRepositoryInterface
{
    public function getAllExams();
    public function createExam(array $request);
    public function getExamById($exam);
    public function updateExam(array $request, $exam);
    public function forceDeleteExam($exam);
}
