<?php

namespace App\Http\Controllers\BBS;

use App\Constants\CommonConstants;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:students');
    $this->middleware(function ($request, $next) {
      // URLのパスに含まれるidが null でなく、かつ認証されたユーザのidでない場合は403を返す。
      $student_id_in_url_path = $request->route()->parameter('student');
      if (!is_null($student_id_in_url_path)) {
        $student_id = (int)Student::findOrFail($student_id_in_url_path)->id;
        if ($student_id != Auth::id()) {
          abort(403);
        }
      }
      return $next($request);
    });
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $notifications = Notification::where('to_user_id', Auth::id())->orderByDesc('created_at')->get();
    $notification_types = CommonConstants::NOTIFICATION_TYPES;

    // 通知を開いたら既読にする
    DB::table('notifications')
      ->where('to_user_id', Auth::id())
      ->update(['is_already_read' => 1]);

    $common = new CommonConstants();
    return view(
      'student.accounts.notification',
      compact(
        'notifications',
        'notification_types',
        'common',
      )
    );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Notification  $notification
   * @return \Illuminate\Http\Response
   */
  public function show(Notification $notification)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Notification  $notification
   * @return \Illuminate\Http\Response
   */
  public function edit(Notification $notification)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Notification  $notification
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Notification $notification)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Notification  $notification
   * @return \Illuminate\Http\Response
   */
  public function destroy(Notification $notification)
  {
    //
  }
}
