<?php

namespace App\Service\Parser;

use App\Service\Contract\Parser\SchoolParser;
use PHPHtmlParser\Dom;

class PaquettgSchoolParser extends PaquettgParser implements SchoolParser
{
    public function parse(string $sessionId): string
    {
        $this->eduTatarClient->setSessionId($sessionId);

        $response = $this->eduTatarClient->getEditProfile();

        $dom = new Dom();
        $dom->loadStr($response->content);

        /** @var Dom\HtmlNode[] $rows */
        $rows = $dom->find(".table tr");

        foreach ($rows as $row) {
            /** @var Dom\HtmlNode[] $tds */
            $tds = $row->find("td");

            if (str_contains($tds[0]->text(), "Школа")) {
                return $tds[1]->text();
            }
        }

        return "";
    }
}
