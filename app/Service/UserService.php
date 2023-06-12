<?php

namespace App\Service;

use App\DTO\UserDTO;
use App\Enum\UserSex;
use App\Exceptions\UserNotFoundException;
use App\Models\User;

class UserService
{
    public function getById(int $id): UserDTO
    {
        $user = User::find($id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $dto = new UserDTO();
        $dto->id = $user->id;
        $dto->name = $user->name;
        $dto->surname = $user->surname;
        $dto->patronymic = $user->patronymic;
        $dto->login = $user->login;
        $dto->sex = UserSex::from($user->sex);
        $dto->createdAt = $user->created_at;
        $dto->updatedAt = $user->updated_at;
        $dto->school = $user->school?->name ?? "";

        return $dto;
    }
}
