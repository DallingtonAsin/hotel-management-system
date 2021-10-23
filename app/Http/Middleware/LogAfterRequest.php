<?php

namespace App\Http\Middleware;
use App\Models\RequestResponse;
use Closure;

class LogAfterRequest
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
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $r = new RequestResponse;
        $r->request = json_encode($request->all());
        $r->response = $response;
        $r->method = $request->method();
        $r->url = $request->fullUrl();
        $r->ip_address = $request->ip();
        $r->save();

    }

    
}
