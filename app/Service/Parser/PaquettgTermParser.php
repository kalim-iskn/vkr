<?php

namespace App\Service\Parser;

use App\DTO\Parser\Term\SubjectDTO;
use App\DTO\Parser\Term\TermDTO;
use App\Service\Contract\Parser\TermParser;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\HtmlNode;

class PaquettgTermParser extends PaquettgParser implements TermParser
{
    public function parse(?string $term = null): TermDTO
    {
        $response = $this->eduTatarClient->getTerm($term);

        $termDto = new TermDTO();

        $dom = new Dom();
        $dom->loadStr($response->content);

        /** @var HtmlNode $termSelectedOption */
        $termSelectedOption = $dom->find("option[selected]")[0];
        $termPeriod = $termSelectedOption->text();
        $termDto->term = $termPeriod == "year" ? $termPeriod : preg_replace("/[^0-9]/", '', $termPeriod);

        /** @var HtmlNode[] $marksRows */
        $marksRows = $dom->find("table.term-marks tbody tr");

        $maxMarksCount = 0;

        for ($i = 0; $i < count($marksRows) - 1; $i++) {
            /** @var HtmlNode[] $tds */
            $tds = $marksRows[$i]->find("td");
            $subjectDTO = new SubjectDTO();
            $subjectDTO->name = $tds[0]->text();
            $subjectDTO->averageMark = floatval($tds[count($tds) - 3]->text());
            $subjectDTO->finalMark = $tds[count($tds) - 1]->text();

            $marksCount = 0;
            for ($j = 1; $j < count($tds) - 3; $j++) {
                $mark = intval($tds[$j]->text());

                if ($mark) {
                    $marksCount++;
                    $subjectDTO->addMark($mark);;
                }
            }

            if ($marksCount > $maxMarksCount) {
                $maxMarksCount = $marksCount;
            }

            $termDto->addSubject($subjectDTO);
        }

        $termDto->maxMarksCount = $maxMarksCount;
        $termDto->totalAverageMark = floatval(
            $marksRows[count($marksRows) - 1]
                ->find("td")[1]
                ->text()
        );

        $class = $dom->find(".h p")[0]->text();
        $class = preg_replace("/[^0-9]/", '', $class);

        $termDto->class = $class;

        return $termDto;
    }
}
