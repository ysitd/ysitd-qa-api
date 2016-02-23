<?php

namespace YSITD\Http\Middleware;

use Closure;

class ApiTokenAuth
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
        if($request->token !== env('API_TOKEN')) {
            return response('Unauthorized API Token.', 403);
        }
        return $next($request);
    }
}
