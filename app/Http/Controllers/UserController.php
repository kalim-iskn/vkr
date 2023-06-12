<?php

namespace App\Http\Controllers;

use App\Service\TermService;
use App\Service\UserService;

class UserController extends Controller
{
    protected UserService $userService;
    protected TermService $termService;

    public function __construct(UserService $userService, TermService $termService)
    {
        $this->userService = $userService;
        $this->termService = $termService;
    }

    public function showProfile(int $id)
    {
        $user = $this->userService->getById($id);
        $isMyProfile = auth()->id() == $user->id;

        return view('profile', [
            'user' => $user,
            'isMyProfile' => $isMyProfile,
            'isSavedTermExists' => $this->termService->isSavedTermExists($id)
        ]);
    }
}
