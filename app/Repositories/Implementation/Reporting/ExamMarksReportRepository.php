<?php

namespace App\Repositories\Implementation\Reporting;

use App\Models\Exam;
use App\Repositories\Interfaces\Reporting\ExamMarksReportRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ExamMarksReportRepository implements ExamMarksReportRepositoryInterface
{
    /**
     * @param Exam $exam
     * @return mixed
     */
    public function getMarksByExam(Exam $exam)
    {
        return Exam::query()
            ->with(['class.teacher.employee.person', 'subject', 'category', 'branch', 'students.person'])
            ->withCount([
                'students as present_count' => function (Builder $query) {
                    $query->whereNot('mark.mark', 'Ab');
                },
                'students as absent_count' => function (Builder $query) {
                    $query->where('mark.mark', 'Ab');
                },
                'students'
            ])->find($exam->examID);
    }
}
