<?php

namespace App\Service\Contract\Parser;

interface SchoolParser
{
    public function parse(string $sessionId): string;
}
