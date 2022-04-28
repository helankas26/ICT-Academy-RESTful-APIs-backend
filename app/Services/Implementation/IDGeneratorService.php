<?php

namespace App\Services\Implementation;

use App\Services\Interfaces\IDGeneratorServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class IDGeneratorService implements IDGeneratorServiceInterface
{
    /**
     * @var IDGeneratorQueryService
     */
    private IDGeneratorQueryService $queryService;

    /**
     * @param IDGeneratorQueryService $queryService
     */
    public function __construct(IDGeneratorQueryService $queryService)
    {
        $this->queryService = $queryService;
    }

    /**
     * @return string
     */
    public function branchID(): string
    {
        return $this->generateID(self::BRANCH, $this->queryService->getBranchIDs());
    }

    /**
     * @return string
     */
    public function staffID(): string
    {
        return $this->generateID(self::STAFF, $this->queryService->getStaffIDs());
    }

    /**
     * @return string
     */
    public function teacherID(): string
    {
        return $this->generateID(self::TEACHER, $this->queryService->getTeacherIDs());
    }

    /**
     * @return string
     */
    public function userID(): string
    {
        return $this->generateID(self::USER, $this->queryService->getUserIDs());
    }

    /**
     * @param string $dob
     * @return string
     */
    public function studentID(string $dob): string
    {
        return $this->generateStudentID($dob, $this->queryService->getStudentIDs());
    }

    /**
     * @return string
     */
    public function categoryID(): string
    {
        return $this->generateID(self::CATEGORY, $this->queryService->getCategoryIDs());
    }

    /**
     * @return string
     */
    public function subjectID(): string
    {
        return $this->generateID(self::SUBJECT, $this->queryService->getSubjectIDs());
    }

    /**
     * @return string
     */
    public function classID(): string
    {
        return $this->generateID(self::CLASSES, $this->queryService->getClassIDs());
    }

    /**
     * @return string
     */
    public function examID(): string
    {
        return $this->generateID(self::EXAM, $this->queryService->getExamIDs());
    }

    /**
     * @param string $prefix
     * @param Collection $currentIDs
     * @return string
     */
    public function generateID(string $prefix, Collection $currentIDs): string
    {
        $id = null;
        $rowCount = $currentIDs->count();

        switch ($prefix) {
            case self::EXAM:

                if ($rowCount > 0) {
                    $counter = (int) Str::remove($prefix , $currentIDs->get($currentIDs->count() - 1));

                    if ($counter < 9999) {
                        if ($counter < 9) {
                            $id = $prefix . '000' . (++$counter);
                        } elseif ($counter < 99) {
                            $id = $prefix . '00' . (++$counter);
                        } elseif ($counter < 999) {
                            $id = $prefix . '0' . (++$counter);
                        }else {
                            $id = $prefix . (++$counter);
                        }
                    } else {
                        $id  = "ID creation limit is exceeded for the system";
                    }
                } elseif ($rowCount == 0) {
                    $id = $prefix . '000' . (++$rowCount);
                }
                break;

            default:
                if ($rowCount > 0) {
                    $counter = (int) Str::remove($prefix , $currentIDs->get($currentIDs->count() - 1));

                    if ($counter < 999) {
                        if ($counter < 9) {
                            $id = $prefix . '00' . (++$counter);
                        } elseif ($counter < 99) {
                            $id = $prefix . '0' . (++$counter);
                        } else {
                            $id = $prefix . (++$counter);
                        }
                    } else {
                        $id  = "ID creation limit is exceeded for the system";
                    }
                } elseif ($rowCount == 0) {
                    $id = $prefix . '00' . (++$rowCount);
                }
        }
        return $id;
    }

    /**
     * @param string $dob
     * @param Collection $currentIDs
     * @return string
     */
    public function generateStudentID(string $dob, Collection $currentIDs): string
    {
        $currentYear = Carbon::createFromFormat('Y-m-d', $dob)->year;
        $id = null;
        $rowCount = $currentIDs->count();

        if ($rowCount > 0) {
            $prevID = $currentIDs->get($currentIDs->count() - 1);
            $prevPrefix = Str::substr($prevID,4, 4);
            $counter = (int) Str::substr($prevID,7, 3);

            $prevYear = Carbon::createFromFormat('Y', $prevPrefix)->year;

            if ($currentYear == $prevYear) {
                if ($counter < 999) {
                    $id = self::STUDENT . $currentYear . (++$counter);
                } else {
                    $id  = "Student ID creation limit is exceeded for the system in this year " . $dob;
                }
            } else if ($currentYear > $prevYear) {
                $id = self::STUDENT . $currentYear + '001';
            } else if ($currentYear < $prevYear) {
                generateStudentID($dob, IDGeneratorQueryService::getStudentIDsByDOB($dob));
            }

        } else if ($rowCount == 0) {
            $id = Self::STUDENT . $currentYear . '00' . (++$rowCount);
        }
        return $id;
    }
}
