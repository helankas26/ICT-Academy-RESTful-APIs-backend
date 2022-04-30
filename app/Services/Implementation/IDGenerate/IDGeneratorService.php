<?php

namespace App\Services\Implementation\IDGenerate;

use App\Services\Interfaces\IDGenerate\IDGenerateServiceInterface;
use App\Services\Interfaces\IDGenerate\IDGeneratorServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class IDGeneratorService implements IDGeneratorServiceInterface
{

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
            case IDGenerateServiceInterface::EXAM:

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
                    $id = IDGenerateServiceInterface::STUDENT . $currentYear . (++$counter);
                } else {
                    $id  = "Student ID creation limit is exceeded for the system in this year " . $dob;
                }
            } else if ($currentYear > $prevYear) {
                $id = IDGenerateServiceInterface::STUDENT . $currentYear + '001';
            } else if ($currentYear < $prevYear) {
                generateStudentID($dob, IDGeneratorQueryService::getStudentIDsByDOB($dob));
            }

        } else if ($rowCount == 0) {
            $id = IDGenerateServiceInterface::STUDENT . $currentYear . '00' . (++$rowCount);
        }
        return $id;
    }
}
