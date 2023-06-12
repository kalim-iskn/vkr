<?php

namespace App\Service;

use App\DTO\Rating\RatingDTO;
use App\DTO\Rating\RatingUserDTO;
use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class RatingService
{
    public const DEFAULT_RATING_CLASS = 9;

    public function addOrUpdate(User $user, float $totalAverageMark): void
    {
        $rating = Rating::where("user_id", $user->id)
            ->first();

        if (!$rating) {
            $rating = new Rating();
            $rating->user_id = $user->id;
        }

        $rating->total_average_mark = $totalAverageMark;
        $rating->save();
    }

    public function getRating(?int $class, ?int $schoolId = null): RatingDTO
    {
        if (!$class) {
            $class = self::DEFAULT_RATING_CLASS;
        } else if (!($class >= 1 && $class <= 11)) {
            throw new Exception("Class should be in [1, 11]");
        }

        $result = Rating::with("user.school")
            ->whereHas("user", function ($query) use ($class, $schoolId) {
                $query->where("class", $class);
                if ($schoolId) {
                    $query->where("school_id", $schoolId);
                }
            })
            ->orderBy("total_average_mark", "desc")
            ->get()
            ->toArray();

        $rating = new RatingDTO();
        $rating->class = $class;

        $place = 1;
        $previousAverageMark = 0;

        foreach ($result as $item) {
            $user = new RatingUserDTO();
            $user->id = $item['user']['id'];
            $user->totalAverageMark = $item['total_average_mark'];
            $user->school = $item['user']['school']['name'] ?? "";
            $user->fullName = $item['user']['name'] . " " . $item['user']['surname'];
            $user->place = $place;
            $user->actualDate = Carbon::create($item['updated_at'])
                ->format("d-m-Y");

            if ($previousAverageMark != $item['total_average_mark']) {
                $place++;
            }

            $rating->addUser($user);
        }

        return $rating;
    }
}
