<?php

namespace App\Http\Controllers\Student\Auth;

use App\Constants\CommonConstants;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
  /**
   * Display the registration view.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view('student.auth.register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request)
  {
    $request->validate([
      'last_name' => ['required', 'string', 'max:20'],
      'first_name' => ['required', 'string', 'max:20'],
      'last_name_kana' => ['required', 'string', 'max:20'],
      'first_name_kana' => ['required', 'string', 'max:20'],
      # 'email' => ['required', 'string', 'email', 'max:100', 'regex:/[1-3]012\w0([0-7][0-9]|80)@kaishi-pu.ac.jp/', 'unique:students'],
      'email' => ['required', 'string', 'email', 'max:100', 'unique:students'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // メールアドレスによって学部学科を自動的に選択
    $student_number = substr($request->email, 0, 8);

    // 学籍番号の上一桁が学部を表す
    if ($student_number[0] === "1") {
      $faculty = CommonConstants::BUSINESS;
    } else if ($student_number[0] === "2") {
      $faculty = CommonConstants::ICT;
    } else if ($student_number[0] === "3") {
      $faculty = CommonConstants::ANIME;
    }

    // API実習提出時はすべて情報学部
    $faculty = CommonConstants::ICT;

    $user = Student::create([
      'last_name' => $request->last_name,
      'first_name' => $request->first_name,
      'last_name_kana' => $request->last_name_kana,
      'first_name_kana' => $request->first_name_kana,
      'email' => $request->email,
      'faculty_id' => $faculty,
      'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(RouteServiceProvider::STUDENT_HOME);
  }
}
