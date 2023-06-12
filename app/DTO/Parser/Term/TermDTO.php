<?php

namespace App\DTO\Parser\Term;

use Carbon\Carbon;

class TermDTO
{
    public string $term;
    public float $totalAverageMark;
    public int $maxMarksCount;
    public int $class;
    public ?Carbon $actualDate = null;
    protected array $subjects;

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
