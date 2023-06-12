<?php

namespace App\Http\Controllers;

use App\Service\TermService;
use App\Service\UserService;
use Illuminate\Http\Request;

class TermController extends Controller
{
    protected TermService $termService;
    protected UserService $userService;

    public function __construct(TermService $termService, UserService $userService)
    {
        $this->termService = $termService;
        $this->userService = $userService;
    }

    public function getTerm(Request $request)
    {
        $termPeriod = $request->get("term");
        $term = $this->termService->getTerm(auth()->id(), $termPeriod);
        $termPeriod = $term->term;

        return view("term", [
            "termPeriod" => $termPeriod,
            "term" => $term,
            "isSaved" => false
        ]);
    }

    public function getSavedTerm(int $userId)
    {
        return view("term", [
            "user" => $this->userService->getById($userId),
            "isSaved" => true,
            "term" => $this->termService->getSavedTerm($userId)
        ]);
    }
}
