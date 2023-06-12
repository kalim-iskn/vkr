<?php

namespace App\DTO\Parser\Login;

use App\DTO\UserDTO;

class LoginDTO extends UserDTO
{
    public string $sessionId;
}
