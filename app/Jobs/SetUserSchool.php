<?php

namespace App\Jobs;

use App\Service\SchoolService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetUserSchool implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    protected int $userId;

    protected string $sessionId;

    public function __construct(int $userId, string $sessionId)
    {
        $this->userId = $userId;
        $this->sessionId = $sessionId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var SchoolService $schoolService */
        $schoolService = app(SchoolService::class);

        $schoolService->setSchool($this->userId, $this->sessionId);
    }
}
