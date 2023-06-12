<?php

namespace App\DTO\Parser\Diary;

class DiaryDTO
{
    public ?string $nextDate = null;
    public ?string $previousDate = null;
    public string $month;
    protected array $days = [];

    public function addDay(DayDTO $dayDTO): void
    {
        $this->days[] = $dayDTO;
    }

    /**
     * @return DayDTO[]
     */
    public function getDays(): array
    {
        return $this->days;
    }
}
