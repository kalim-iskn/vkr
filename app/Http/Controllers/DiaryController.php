<?php

namespace App\Http\Controllers;

use App\Service\DiaryService;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    protected DiaryService $diaryService;

    public function __construct(DiaryService $diaryService)
    {
        $this->diaryService = $diaryService;
    }

    public function getDiary(Request $request)
    {
        $date = $request->get("date");
        return view("diary", [
            "diary" => $this->diaryService->getDiary($date)
        ]);
    }
}
