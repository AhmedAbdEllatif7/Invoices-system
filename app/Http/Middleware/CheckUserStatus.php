<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
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
    
        $user = Auth::user();

        if ($user && $user->status == 'مفعل') {
            return $next($request);
        }

        // If the user is logged out, redirect to the login page
        if (!$user && $request->route()->named('login')) {
            return redirect('/')->with('status', 'من فضلك سجل دخولك');
        }

        // If the user is logged in but their status is not active, force logout and redirect to login
        if ($user) {
            Auth::logout();
        }

        return redirect('/')->with('status', 'عفوا هذا الحساب غير مفعل, يمكنك المحاولة فيما بعد');
        }
    }

