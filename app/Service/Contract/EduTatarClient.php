<?php

namespace App\Service\Contract;

use App\DTO\Response\ClientResponseDTO;
use App\DTO\Response\LoginResponseDTO;
use App\Exceptions\EduTatarAuthException;
use App\Exceptions\EduTatarRequestException;
use App\Http\Requests\LoginRequest;

interface EduTatarClient
{
    /**
     * @param string $sessionId
     * @return void
     */
    public function setSessionId(string $sessionId): void;

    /**
     * @param LoginRequest $request
     * @return LoginResponseDTO
     * @throws EduTatarAuthException
     */
    public function login(LoginRequest $request): LoginResponseDTO;

    /**
     * @param string|null $term
     * @return ClientResponseDTO
     * @throws EduTatarRequestException
     */
    public function getTerm(?string $term = null): ClientResponseDTO;

    /**
     * @param string|null $date
     * @return ClientResponseDTO
     * @throws EduTatarRequestException
     */
    public function getDiary(?string $date = null): ClientResponseDTO;

    /**
     * @return ClientResponseDTO
     */
    public function getEditProfile(): ClientResponseDTO;
}
