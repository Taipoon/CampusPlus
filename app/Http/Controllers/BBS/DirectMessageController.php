<?php

namespace App\Http\Controllers\BBS;

use App\Http\Controllers\Controller;
use App\Models\DirectMessage;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirectMessageController extends Controller
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
  public function index($id)
  {
    $direct_messages = DirectMessage::where('user_id', $id);
    return view(
      'common.bbs.direct_messages.index',
      compact('direct_messages')
    );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create($id)
  {
    return view('common.bbs.direct_messages.create');
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
   * @param  \App\Models\DirectMessage  $directMessage
   * @return \Illuminate\Http\Response
   */
  public function show(DirectMessage $directMessage)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\DirectMessage  $directMessage
   * @return \Illuminate\Http\Response
   */
  public function edit(DirectMessage $directMessage)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\DirectMessage  $directMessage
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, DirectMessage $directMessage)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\DirectMessage  $directMessage
   * @return \Illuminate\Http\Response
   */
  public function destroy(DirectMessage $directMessage)
  {
    //
  }
}
