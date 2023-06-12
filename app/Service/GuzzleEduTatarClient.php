<?php

namespace App\Service;

use App\DTO\Response\ClientResponseDTO;
use App\DTO\Response\LoginResponseDTO;
use App\Exceptions\EduTatarAuthException;
use App\Exceptions\EduTatarRequestException;
use App\Http\Requests\LoginRequest;
use App\Service\Contract\EduTatarClient;
use Error;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;

class GuzzleEduTatarClient implements EduTatarClient
{
    protected Client $client;
    protected string $baseUri;
    protected string $cookieDomain;
    protected ?string $sessionId = null;
    protected ?CookieJar $requestCookies = null;
    protected string $defaultUserAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36";

    public function __construct()
    {
        $this->baseUri = config("edu-tatar.base_uri");
        $this->cookieDomain = config("edu-tatar.cookie_domain");

        if ($this->baseUri === null || $this->cookieDomain === null) {
            throw new Error("EDU TATAR URIs NOT SPECIFIED");
        }

        $this->client = new Client([
            "base_uri" => $this->baseUri,
            'verify' => false,
            'allow_redirects' => true,
            'cookies' => true,
            'headers' => [
                'Referer' => $this->baseUri . '/logon',
                'User-Agent' => $_SERVER['HTTP_USER_AGENT'] ?? $this->defaultUserAgent
            ]
        ]);
    }

    public function setSessionId(string $sessionId): void
    {
        $this->sessionId = $sessionId;
        $this->requestCookies = CookieJar::fromArray([
            'DNSID' => $sessionId
        ], $this->cookieDomain);
    }

    public function login(LoginRequest $request): LoginResponseDTO
    {
        $jar = new CookieJar();

        $response = $this->client->post("logon", [
            'form_params' => [
                'main_login2' => $request->login,
                'main_password2' => $request->password
            ],
            'cookies' => $jar
        ]);

        $responseDto = new LoginResponseDTO();
        $sessionId = null;

        $iterator = $jar->getIterator();
        while ($iterator->valid()) {
            /** @var SetCookie $cookie */
            $cookie = $iterator->current();

            if ($cookie->getName() == 'DNSID') {
                $sessionId = $cookie->getValue();
            }

            $iterator->next();
        }

        if (empty($sessionId)) {
            throw new EduTatarAuthException();
        }

        $responseDto->sessionId = $sessionId;
        $responseDto->content = $response->getBody()->getContents();

        return $responseDto;
    }

    public function getTerm(?string $term = null): ClientResponseDTO
    {
        $url = "user/diary/term";

        if ($term !== null) {
            $url .= "?term=$term";
        }

        $response = $this->client->get($url, [
            'cookies' => $this->requestCookies
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new EduTatarRequestException();
        }

        $responseDto = new ClientResponseDTO();
        $responseDto->content = $response->getBody()->getContents();

        return $responseDto;
    }

    public function getDiary(?string $date = null): ClientResponseDTO
    {
        $url = "user/diary/week";

        if ($date !== null) {
            $url .= "?date=$date";
        }

        $response = $this->client->get($url, [
            'cookies' => $this->requestCookies
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new EduTatarRequestException();
        }

        $responseDto = new ClientResponseDTO();
        $responseDto->content = $response->getBody()->getContents();

        return $responseDto;
    }

    public function getEditProfile(): ClientResponseDTO
    {
        $response = $this->client->get("user/anketa/edit", [
            'cookies' => $this->requestCookies
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new EduTatarRequestException();
        }

        $responseDto = new ClientResponseDTO();
        $responseDto->content = $response->getBody()->getContents();

        return $responseDto;
    }
}
