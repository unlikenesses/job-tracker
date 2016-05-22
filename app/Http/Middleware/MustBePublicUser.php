<?php

namespace App\Http\Middleware;

use Closure;

class MustBePublicUser
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
        $user = $request->user();
        if ($user && $user->isPublic) {
            return $next($request);
        }
        abort(404, 'NO!');
    }
}
