<?php

namespace App\Http\Middleware\Document;

use App\Helpers\Helpers;
use Closure;
use Illuminate\Http\Request;

class CheckRegistrationNumber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Helpers::checkRegistrationNumber($request->registrationNumber)){
            abort(500);
        }
        return $next($request);
    }
}
