<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
  /**
   * Display the login view.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view('student.auth.login');
  }

  /**
   * Handle an incoming authentication request.
   *
   * @param  \App\Http\Requests\Auth\LoginRequest  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(LoginRequest $request)
  {
    $request->authenticate();

    $request->session()->regenerate();

    /**
     * 最終ログインの日時を保存
     */
    if ($request->routeIs('student.*')) {
      DB::table('students')->where('id', Auth::id())->update(['last_login_at' => now()]);
    }
    return redirect()->intended(RouteServiceProvider::STUDENT_HOME);
  }

  /**
   * Destroy an authenticated session.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy(Request $request)
  {
    DB::table('students')->where('id', Auth::id())->update(['last_logout_at' => now()]);
    Auth::guard('students')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/student/login');
  }
}
