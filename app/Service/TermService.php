<?php

namespace App\Service;

use App\DTO\Parser\Term\TermDTO;
use App\Exceptions\SavedTermNotFoundException;
use App\Models\Term;
use App\Models\User;
use App\Service\Contract\Parser\TermParser;
use App\Service\Serialization\TermSerializer;

class TermService
{
    protected TermParser $termParser;
    protected RatingService $ratingService;
    protected TermSerializer $termSerializer;

    public function __construct(TermParser $termParser, RatingService $ratingService, TermSerializer $termSerializer)
    {
        $this->termParser = $termParser;
        $this->ratingService = $ratingService;
        $this->termSerializer = $termSerializer;
    }

    public function getTerm(int $userId, ?string $term = null): TermDTO
    {
        $termDto = $this->termParser->parse($term);

        $user = User::find($userId);
        if (!$user->class) {
            $user->class = $termDto->class;
            $user->save();
        }

        $this->ratingService->addOrUpdate($user, $termDto->totalAverageMark);
        $this->saveTerm($user, $termDto);

        return $termDto;
    }

    /**
     * @throws SavedTermNotFoundException
     */
    public function getSavedTerm(int $userId): TermDTO
    {
        $term = Term::where("user_id", $userId)
            ->first();

        if (!$term) {
            throw new SavedTermNotFoundException();
        }

        $termDTO = $this->termSerializer->deserialize($term->term);
        $termDTO->actualDate = $term->updated_at;

        return $termDTO;
    }

    public function isSavedTermExists(int $userId): bool
    {
        return Term::where("user_id", $userId)->exists();
    }

    protected function saveTerm(User $user, TermDTO $termDTO): void
    {
        $term = Term::where("user_id", $user->id)
            ->first();

        if (!$term) {
            $term = new Term();
            $term->user_id = $user->id;
        }

        $term->term = $this->termSerializer->serialize($termDTO);

        $term->save();
    }
}
