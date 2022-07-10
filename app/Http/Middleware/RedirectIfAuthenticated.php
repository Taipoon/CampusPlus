<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    private const GUARD_TEACHER = 'teachers';
    private const GUARD_STUDENT = 'students';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        // foreach ($guards as $guard) {
        //     if (Auth::guard($guard)->check()) {
        //         return redirect(RouteServiceProvider::HOME);
        //     }
        // }    

        // teachers ガードにより認証されたユーザのリダイレクト先
        if (Auth::guard(self::GUARD_TEACHER)->check() && $request->routeIs('teacher.*')) {
            return redirect(RouteServiceProvider::TEACHER_HOME);
        }

        // students ガードにより認証されたユーザのリダイレクト先
        if (Auth::guard(self::GUARD_STUDENT)->check() && $request->routeIs('student.*')) {
            return redirect(RouteServiceProvider::STUDENT_HOME);
        }
        return $next($request);
    }
}
