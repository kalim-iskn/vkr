<?php

namespace App\Providers;

use App\Service\Contract\EduTatarClient;
use App\Service\Contract\Parser\DiaryParser;
use App\Service\Contract\Parser\LoginParser;
use App\Service\Contract\Parser\SchoolParser;
use App\Service\Contract\Parser\TermParser;
use App\Service\GuzzleEduTatarClient;
use App\Service\Parser\PaquettgDiaryParser;
use App\Service\Parser\PaquettgLoginParser;
use App\Service\Parser\PaquettgSchoolParser;
use App\Service\Parser\PaquettgTermParser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EduTatarClient::class, GuzzleEduTatarClient::class);

        $this->app->bind(LoginParser::class, PaquettgLoginParser::class);
        $this->app->bind(TermParser::class, PaquettgTermParser::class);
        $this->app->bind(DiaryParser::class, PaquettgDiaryParser::class);
        $this->app->bind(SchoolParser::class, PaquettgSchoolParser::class);
    }
}
