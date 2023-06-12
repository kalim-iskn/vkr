<?php

namespace App\Http\Middleware;

use App\Service\AuthService;
use App\Service\Contract\EduTatarClient;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class EduTatarSession
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var EduTatarClient $client */
        $client = app(EduTatarClient::class);
        $sessionValue = Session::get(AuthService::EDU_TATAR_SESSION_ID_NAME);

        if ($sessionValue) {
            $client->setSessionId($sessionValue);
        }

        return $next($request);
    }
}
