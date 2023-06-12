<?php

namespace App\DTO\Rating;

class RatingDTO
{
    public int $class;
    public ?string $school = null;
    protected array $users = [];

    public function addUser(RatingUserDTO $ratingUserDto): void
    {
        $this->users[] = $ratingUserDto;
    }

    /**
     * @return RatingUserDTO[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }
}
