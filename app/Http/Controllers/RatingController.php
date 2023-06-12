<?php

namespace App\Http\Controllers;

use App\Service\RatingService;
use App\Service\SchoolService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected RatingService $ratingService;
    protected SchoolService $schoolService;

    public function __construct(RatingService $ratingService, SchoolService $schoolService)
    {
        $this->ratingService = $ratingService;
        $this->schoolService = $schoolService;
    }

    public function get(Request $request)
    {
        $class = $request->get("class") ?? auth()->user()->class;

        if ($class) {
            $class = intval($class);
        }

        $schools = $this->schoolService->getAll();
        $selectedSchool = intval($request->get("school"));
        $rating = $this->ratingService->getRating($class, $selectedSchool);

        return view("rating", [
            "selectedClass" => $class,
            "selectedSchool" => $selectedSchool,
            "schools" => $schools,
            "rating" => $rating
        ]);
    }
}
