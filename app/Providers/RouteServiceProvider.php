<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
  // マルチログイン機能のルートサービスプロパイダの設定
  public const TEACHER_HOME = '/teacher/dashboard';
  public const STUDENT_HOME = '/student/dashboard';

  /**
   * The path to the "home" route for your application.
   *
   * This is used by Laravel authentication to redirect users after login.
   *
   * @var string
   */
  public const HOME = '/dashboard';

  /**
   * The controller namespace for the application.
   *
   * When present, controller route declarations will automatically be prefixed with this namespace.
   *
   * @var string|null
   */
  // protected $namespace = 'App\\Http\\Controllers';

  /**
   * Define your route model bindings, pattern filters, etc.
   *
   * @return void
   */
  public function boot()
  {
    $this->configureRateLimiting();

    $this->routes(function () {
      Route::prefix('api')
        ->middleware('api')
        ->namespace($this->namespace)
        ->group(base_path('routes/api.php'));

      Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/web.php'));

      // Create URL Prefix  /teacher/*** -> teacher.***
      Route::prefix('/teacher')->as('teacher.')
        ->middleware('web')->namespace($this->namespace)
        ->group(base_path('routes/teacher.php'));

      // Create URL Prefix  /student/*** -> student.***
      Route::prefix('/student')->as('student.')
        ->middleware('web')->namespace($this->namespace)
        ->group(base_path('routes/student.php'));
    });
    // パラメーターの制約
    // Route::pattern(['thread' => '[0-9]+', 'comment' => '[0-9]+']);
  }

  /**
   * Configure the rate limiters for the application.
   *
   * @return void
   */
  protected function configureRateLimiting()
  {
    RateLimiter::for('api', function (Request $request) {
      return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
    });
  }
}
