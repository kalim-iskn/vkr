<?php

namespace App\Service\Contract\Parser;

use App\DTO\Parser\Login\LoginDTO;
use App\Http\Requests\LoginRequest;

interface LoginParser
{
    public function parse(LoginRequest $request): LoginDTO;
}
