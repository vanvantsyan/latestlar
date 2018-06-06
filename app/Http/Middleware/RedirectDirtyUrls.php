<?php

namespace App\Http\Middleware;

use Closure;

class RedirectDirtyUrls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Получаем требуемый url
        $url = $request->path();
        
        // Если он содержит нежелательные символы, то очищаем и редиректим.
        if (!$this->isClean($url))
            return redirect($this->purify($url), 301);
        
        return $next($request);
    }

    /**
     * Проверяет, содержит ли slug нежелательные символы.
     *
     * @param $url
     * @return bool
     */
    public function isClean($url)
    {
        if (!preg_match('/[(),]/', $url))
            return true;

        return false;
    }

    /**
     * Убирает нежелательные символы.
     *
     * @param $url
     * @return null|string|string[]
     */
    public function purify($url)
    {
        $clean = preg_replace('/[(),]/', '', $url);

        return $clean;
    }
}
