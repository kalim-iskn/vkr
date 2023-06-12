<?php

namespace Tests\Feature;

use App\DTO\Response\ClientResponseDTO;
use App\DTO\Response\LoginResponseDTO;
use App\Http\Requests\LoginRequest;
use App\Service\Contract\EduTatarClient;

class TestClient implements EduTatarClient
{
    public function login(LoginRequest $request): LoginResponseDTO
    {
        $dto = new LoginResponseDTO();
        $dto->sessionId = "test";
        $dto->content = file_get_contents(__DIR__ . '/data/anketa.html');

        return $dto;
    }

    public function getTerm(?string $term = null): ClientResponseDTO
    {
        $dto = new ClientResponseDTO();
        $dto->content = file_get_contents(__DIR__ . '/data/term.html');

        return $dto;
    }

    public function getDiary(?string $date = null): ClientResponseDTO
    {
        $dto = new ClientResponseDTO();
        $dto->content = file_get_contents(__DIR__ . '/data/diary.html');

        return $dto;
    }

    public function getEditProfile(): ClientResponseDTO
    {
        $dto = new ClientResponseDTO();
        $dto->content = file_get_contents(__DIR__ . '/data/edit.html');

        return $dto;
    }

    public function setSessionId(string $sessionId): void
    {
    }
}
