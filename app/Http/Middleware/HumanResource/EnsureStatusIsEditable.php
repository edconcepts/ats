<?php

namespace App\Http\Middleware\HumanResource;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStatusIsEditable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->status->id === config('status.archive_status_id')){
            abort(404);
        }
        return $next($request);
    }
}
