<?php

namespace App\Service\Parser;

use App\DTO\Parser\Diary\DayDTO;
use App\DTO\Parser\Diary\DiaryDTO;
use App\DTO\Parser\Diary\SubjectDTO;
use App\Enum\DayOfWeek;
use App\Service\Contract\Parser\DiaryParser;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\HtmlNode;

class PaquettgDiaryParser extends PaquettgParser implements DiaryParser
{
    public function parse(?string $date = null): DiaryDTO
    {
        $response = $this->eduTatarClient->getDiary($date);

        $dom = new Dom();
        $dom->loadStr($response->content);

        $diaryDTO = new DiaryDTO();
        $diaryDTO->month = $dom->find(".week-selector span")[0]->text();

        /** @var HtmlNode[] $buttons */
        $buttons = $dom->find(".g-button-blue");

        foreach ($buttons as $button) {
            $text = $button->text();
            $date = mb_substr(stristr($button->getAttribute("href"), "="), 1);
            if (str_contains($text, "Следующая")) {
                $diaryDTO->nextDate = $date;
            } else {
                $diaryDTO->previousDate = $date;
            }
        }

        /** @var HtmlNode[] $subjectsRows */
        $subjectsRows = $dom->find("tbody tr");

        $dayDto = new DayDTO();
        foreach ($subjectsRows as $row) {
            $rowClass = $row->getAttribute("class");

            /** @var HtmlNode[] $tds */
            $tds = $row->find("td");

            $subjectDto = new SubjectDTO();
            foreach ($tds as $td) {
                $class = $td->getAttribute("class");
                $text = trim(strip_tags($td->innerHtml()));

                switch ($class) {
                    case "tt-days":
                        $dayDto->day = $text;
                        break;
                    case "tt-subj":
                        $subjectDto->name = $text;
                        break;
                    case "tt-task":
                        $subjectDto->homeTask = $text;
                        break;
                    case "tt-mark":
                        $subjectDto->mark = $text;
                        break;
                }
            }

            if ($subjectDto->name != "") {
                $dayDto->addSubject($subjectDto);
            }

            if ($rowClass == "tt-separator") {
                $diaryDTO->addDay($dayDto);
                $dayDto = new DayDTO();
            }
        }

        if (isset($dayDto->day)) {
            $diaryDTO->addDay($dayDto);
        }

        $isStartsWithMonday = $dom->find('.tt-days-mo')->count() > 0;
        $daysOfWeek = DayOfWeek::cases();
        $i = $isStartsWithMonday ? 0 : 3;

        foreach ($diaryDTO->getDays() as $day) {
            $day->dayOfWeek = $daysOfWeek[$i];
            $i++;
        }

        return $diaryDTO;
    }
}
