<?php

namespace YSITD\Http\Middleware;

use Closure;

class ApiUserIdRequired
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
        if(!$request->user_id) {
            return response('Empty user_id.', 403);
        }
        return $next($request);
    }
}
