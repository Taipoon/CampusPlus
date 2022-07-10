<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    protected $teacher_route = 'teacher.login';
    protected $student_route = 'student.login';
    // protected $api_route = 'api.unauthenticated';
    protected $common_route = 'common.welcome';

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }

        if (!$request->expectsJson()) {
            if (Route::is('teacher.*')) {
                return route($this->teacher_route);
            } else if (Route::is('student.*')) {
                return route($this->student_route);
            } else {
                return route($this->common_route);
            }
        }
    }
}
