<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class AssinGuard extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard != null) {
            auth()->shouldUse($guard); //shoud you user guard / table
            $token = $request->header('auth_token');
            $request->headers->set('auth_token', (string) $token, true);
            $request->headers->set('Authorization', 'Bearer ' . $token, true);
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (TokenExpiredException $e) {
                return response()->json(['msg' => '401 Unauthenticated user']);
            } catch (JWTException $e) {
                return response()->json(['msg' => 'token_invalid' . $e->getMessage()]);
            }
        }
        return $next($request);
    }
}
