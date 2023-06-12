<?php

namespace App\Service\Serialization;

use App\DTO\Parser\Term\SubjectDTO;
use App\DTO\Parser\Term\TermDTO;

class TermSerializer
{
    public function serialize(TermDTO $termDTO): string
    {
        $data = [
            "term" => $termDTO->term,
            "totalAverageMark" => $termDTO->totalAverageMark,
            "maxMarksCount" => $termDTO->maxMarksCount,
            "class" => $termDTO->class,
            "subjects" => []
        ];

        foreach ($termDTO->getSubjects() as $subjectDTO) {
            $data['subjects'][] = [
                "name" => $subjectDTO->name,
                "averageMark" => $subjectDTO->averageMark,
                "finalMark" => $subjectDTO->finalMark,
                "marks" => $subjectDTO->getMarks()
            ];
        }

        return json_encode($data);
    }

    public function deserialize(string $json): TermDTO
    {
        $data = json_decode($json, true);

        $term = new TermDTO();
        $term->term = $data['term'];
        $term->class = $data['class'];
        $term->totalAverageMark = $data['totalAverageMark'];
        $term->maxMarksCount = $data['maxMarksCount'];

        foreach ($data['subjects'] as $subjectData) {
            $subjectDto = new SubjectDTO();
            $subjectDto->name = $subjectData['name'];
            $subjectDto->averageMark = $subjectData['averageMark'];
            $subjectDto->finalMark = $subjectData['finalMark'];
            $subjectDto->setMarks($subjectData['marks']);

            $term->addSubject($subjectDto);
        }

        return $term;
    }
}
