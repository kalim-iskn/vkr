<?php

namespace App\DTO;

use App\Enum\UserSex;
use Illuminate\Support\Carbon;

class UserDTO
{
    public ?int $id = null;
    public string $login;
    public string $name;
    public string $surname;
    public ?string $patronymic = null;
    public UserSex $sex;
    public ?Carbon $createdAt = null;
    public ?Carbon $updatedAt = null;
    public string $school = "";

    public function getFullName(): string
    {
        return $this->name . " " . $this->surname;
    }
}
