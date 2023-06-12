<?php

namespace App\DTO\Rating;

use Carbon\Carbon;

class RatingUserDTO
{
    public int $id;
    public int $place;
    public string $fullName;
    public string $school;
    public float $totalAverageMark;
    public string $actualDate;
}
