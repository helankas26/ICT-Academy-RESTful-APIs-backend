<?php

namespace App\Repositories\Interfaces\Reporting;

use App\Models\Exam;

interface ExamMarksReportRepositoryInterface
{
    /**
     * @param Exam $exam
     * @return mixed
     */
    public function getMarksByExam(Exam $exam);
}
