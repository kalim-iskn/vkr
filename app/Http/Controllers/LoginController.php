<?php

namespace App\Http\Controllers;

use App\Exceptions\EduTatarAuthException;
use App\Http\Requests\LoginRequest;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    protected AuthService $loginService;

    public function __construct(AuthService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function showForm(Request $request)
    {
        return view("index", [
            "credentialsInvalid" => Session::get('credentialsInvalid', 0)
        ]);
    }

    public function login(LoginRequest $request)
    {
        try {
            $this->loginService->login($request);
        } catch (EduTatarAuthException) {
            return redirect()->route('login')
                ->with("credentialsInvalid", 1);
        }
        return redirect()->route('home');
    }
}
