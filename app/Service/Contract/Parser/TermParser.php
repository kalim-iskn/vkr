<?php

namespace App\Service\Contract\Parser;

use App\DTO\Parser\Term\TermDTO;

interface TermParser
{
    public function parse(?string $term = null): TermDTO;
}
