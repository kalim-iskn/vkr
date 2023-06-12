<?php

namespace App\DTO\Parser\Diary;

use App\Enum\DayOfWeek;

class DayDTO
{
    public int $day;
    public DayOfWeek $dayOfWeek;
    protected array $subjects = [];

    public function addSubject(SubjectDTO $subjectDTO): void
    {
        $this->subjects[] = $subjectDTO;
    }

    /**
     * @return SubjectDTO[]
     */
    public function getSubjects(): array
    {
        return $this->subjects;
    }
}
