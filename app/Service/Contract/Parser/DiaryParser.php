<?php

namespace App\Service\Contract\Parser;

use App\DTO\Parser\Diary\DiaryDTO;

interface DiaryParser
{
    public function parse(?string $date = null): DiaryDTO;
}
