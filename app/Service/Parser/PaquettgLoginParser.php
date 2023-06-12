<?php

namespace App\Service\Parser;

use App\DTO\Parser\Login\LoginDTO;
use App\Enum\UserSex;
use App\Exceptions\EduTatarAuthException;
use App\Http\Requests\LoginRequest;
use App\Service\Contract\Parser\LoginParser;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\HtmlNode;

class PaquettgLoginParser extends PaquettgParser implements LoginParser
{
    public function parse(LoginRequest $request): LoginDTO
    {
        $response = $this->eduTatarClient->login($request);

        $dto = new LoginDTO();
        $dto->sessionId = $response->sessionId;

        $dom = new Dom();
        $dom->loadStr($response->content);

        if ($dom->find('.alert-danger')->count() > 0) {
            throw new EduTatarAuthException();
        }

        $table = $dom->find('.tableEx')[0];

        /** @var HtmlNode[] $allTd */
        $allTd = $table->find("td");
        for ($i = 0; $i < count($allTd) - 1; $i += 2) {
            $field = strip_tags($allTd[$i]->innerhtml);
            $value = strip_tags($allTd[$i + 1]->innerhtml);

            switch ($field) {
                case "Имя:":
                    $this->parseName($dto, $value);
                    break;
                case "Логин:":
                    $dto->login = $value;
                    break;
                case "Пол:":
                    $dto->sex = $value == "мужской" ? UserSex::Male : UserSex::Female;
                    break;
            }
        }

        return $dto;
    }

    protected function parseName(LoginDTO $dto, string $name): void
    {
        $names = explode(' ', $name);
        $dto->surname = $names[0];
        $dto->name = $names[1];
        $dto->patronymic = $names[2] ?? null;
    }
}
