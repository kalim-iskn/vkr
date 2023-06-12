<?php

namespace App\DTO\Parser\Term;

class SubjectDTO
{
    public string $name;
    public float $averageMark;
    public string $finalMark = "";
    protected array $marks = [];

    public function addMark(int $mark): void
    {
        $this->marks[] = $mark;
    }

    /**
     * @return int[]
     */
    public function getMarks(): array
    {
        return $this->marks;
    }

    public function setMarks(array $marks): void
    {
        $this->marks = $marks;
    }
}
