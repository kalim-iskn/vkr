<?php

namespace App\Service\Parser;

use App\Service\Contract\EduTatarClient;

abstract class PaquettgParser
{
    protected EduTatarClient $eduTatarClient;

    public function __construct(EduTatarClient $eduTatarClient)
    {
        $this->eduTatarClient = $eduTatarClient;
    }
}
