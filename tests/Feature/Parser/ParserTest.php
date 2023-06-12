<?php

namespace Tests\Feature\Parser;

use App\Http\Requests\LoginRequest;
use App\Service\Contract\EduTatarClient;
use App\Service\Contract\Parser\DiaryParser;
use App\Service\Contract\Parser\LoginParser;
use App\Service\Contract\Parser\SchoolParser;
use App\Service\Contract\Parser\TermParser;
use Tests\Feature\TestClient;
use Tests\TestCase;

class ParserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->app->bind(EduTatarClient::class, TestClient::class);
    }

    public function testLogin()
    {
        /** @var LoginParser $loginParser */
        $loginParser = app(LoginParser::class);
        $dto = $loginParser->parse(new LoginRequest());
        var_dump($dto);
    }

    public function testTerm()
    {
        /** @var TermParser $termParser */
        $termParser = app(TermParser::class);
        $dto = $termParser->parse();
        #var_dump($dto);
    }

    public function testDiary()
    {
        /** @var DiaryParser $diaryParser */
        $diaryParser = app(DiaryParser::class);
        $dto = $diaryParser->parse();
        #var_dump($dto);
    }

    public function testSchool()
    {
        /** @var SchoolParser $schoolParser */
        $schoolParser = app(SchoolParser::class);
        $school = $schoolParser->parse(1, "");
        var_dump($school);
    }
}
