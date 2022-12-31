<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = 'apimembers')
    {
        $member = auth()->guard($guard)->user();
        if (!$member) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $request->id = $member->id;

        return $next($request);
    }
}
