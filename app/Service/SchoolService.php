<?php

namespace App\Service;

use App\Models\School;
use App\Models\User;
use App\Service\Contract\Parser\SchoolParser;
use Illuminate\Database\Eloquent\Collection;

class SchoolService
{
    protected SchoolParser $schoolParser;

    public function __construct(SchoolParser $schoolParser)
    {
        $this->schoolParser = $schoolParser;
    }

    public function setSchool(int $userId, string $sessionId): void
    {
        $user = User::find($userId);

        if (!$user) {
            return;
        }

        $schoolName = $this->schoolParser->parse($sessionId);

        $school = School::firstOrCreate([
            "name" => $schoolName
        ]);

        $user->school_id = $school->id;
        $user->save();
    }

    public function getAll(): Collection
    {
        return School::all();
    }
}
