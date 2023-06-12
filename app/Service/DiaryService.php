<?php

namespace App\Service;

use App\DTO\Parser\Diary\DiaryDTO;
use App\Service\Contract\Parser\DiaryParser;

class DiaryService
{
    protected DiaryParser $diaryParser;

    public function __construct(DiaryParser $diaryParser)
    {
        $this->diaryParser = $diaryParser;
    }

    public function getDiary(?string $date = null): DiaryDTO
    {
        return $this->diaryParser->parse($date);
    }
}
