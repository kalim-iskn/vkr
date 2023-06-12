<?php

namespace App\Service;

use App\Http\Requests\LoginRequest;
use App\Service\Contract\EduTatarClient;
use Illuminate\Support\Facades\Auth;

class EduTatarService
{
    protected EduTatarClient $eduTatarClient;

    public function __construct(EduTatarClient $eduTatarClient)
    {
        $this->eduTatarClient = $eduTatarClient;
    }

    public function login(LoginRequest $request)
    {
        $sessionId = $this->eduTatarClient->login($request);
        Auth::login();
    }
}
