<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class NgrokOverHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Config::get('app.env') !== 'local') {
            return $next($request);
        }

        if ($this->requestComesFromNgrok($request)) {
            URL::forceScheme('https');

            Config::set('debugbar.enabled', false);
        }

        return $next($request);
    }

    private function requestComesFromNgrok(Request $request): bool
    {
        return Str::endsWith($request->getHost(), 'ngrok-free.app');
    }
}
