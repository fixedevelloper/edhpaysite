<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    /*    if ($request->user()->role =="ROLE_USER"){
            return redirect(RouteServiceProvider::HOME);
        }
        return $next($request);*/
        if (Auth::user() && (Auth::user()->user_type === User::ADMIN_TYPE || Auth::user()->user_type === User::AGENT_TYPE|| Auth::user()->user_type === User::CAISSE_TYPE)) {
            return $next($request);
        }
        return redirect()->route('home');
    }
}
