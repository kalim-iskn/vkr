<?php

namespace App\Service;

use App\DTO\Parser\Login\LoginDTO;
use App\Http\Requests\LoginRequest;
use App\Jobs\SetUserSchool;
use App\Models\User;
use App\Service\Contract\Parser\LoginParser;
use Auth;

class AuthService
{
    public const EDU_TATAR_SESSION_ID_NAME = "eduTatarSessionId";
    protected LoginParser $loginParser;

    public function __construct(LoginParser $loginParser)
    {
        $this->loginParser = $loginParser;
    }

    public function login(LoginRequest $request): void
    {
        $dto = $this->loginParser->parse($request);

        $user = User::whereLogin($dto->login)
            ->first();

        if ($user === null) {
            $user = $this->register($dto);
        }

        Auth::login($user);

        $request->session()->put(self::EDU_TATAR_SESSION_ID_NAME, $dto->sessionId);
    }

    protected function register(LoginDTO $dto): User
    {
        $user = new User();
        $user->login = $dto->login;
        $user->name = $dto->name;
        $user->surname = $dto->surname;
        $user->patronymic = $dto->patronymic;
        $user->sex = $dto->sex->value;

        $user->save();

        SetUserSchool::dispatch($user->id, $dto->sessionId);

        return $user;
    }
}
