<?php

namespace App\Http\Controllers\Student;

use App\Constants\CommonConstants;
use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\PrimaryCategory;
use App\Models\Status;
use App\Models\Student;
use App\Models\Thread;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class StudentController extends Controller
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
    })->except(['show', 'showThreads']);
  }
  /**
   * 個人アカウント編集画面
   */
  public function edit($id)
  {
    $student = Student::findOrFail($id);
    return view('student.accounts.edit', compact('student'));
  }

  /**
   * 個人アカウント編集
   */
  public function update(Request $request)
  {
    $student = Student::findOrFail(Auth::id());
    // current_password に値が入力されていればパスワード変更
    if ($request->input('current_password')) {
      $request->validate([
        'current_password' => 'required|current_password:students',
        'new_password' => 'required|confirmed|min:8',
      ]);
      $student->password = Hash::make($request->new_password);
    }

    $request->validate([
      'profile' => 'nullable|max:1000',
      'profile_image' => 'nullable|image|mimes:png,jpg|max:10240',
      'icon_image' => 'nullable|image|mimes:png,jpg|max:10240',
      'twitter' => 'nullable|active_url|max:255',
      'github' => 'nullable|active_url|max:255',
      'instagram' => 'nullable|active_url|max:255',
      'youtube' => 'nullable|active_url|max:255',
      'url' => 'nullable|active_url',
      'information' => 'nullable|max:2000',
    ]);

    // プロフィール画像(16:9)を public/storage/students/profiles に保存してファイル名をDBへ保存
    if (!is_null($request->file('profile_image'))) {
      // Storage::delete(['students/' . $student->profile_image->filename, 'students/1080x1080_' . $student->image_filename]);
      $profile_image_filename = ImageService::profileImageUpload($request->file('profile_image'), 'students/profiles');
      $student->profile_image_filename = $profile_image_filename;
    }
    // アイコン画像(1:1)を public/storage/students/icons に保存してファイル名をDBへ保存
    if (!is_null($request->file('icon_image'))) {
      $icon_image_filename = ImageService::iconImageUpload($request->file('icon_image'), 'students/icons');
      $student->icon_image_filename = $icon_image_filename;
    }
    $student->profile = $request->profile;
    $student->twitter = $request->twitter;
    $student->github = $request->github;
    $student->instagram = $request->instagram;
    $student->youtube = $request->youtube;
    $student->url = $request->url;
    $student->information = $request->information;
    $student->save();

    return redirect()->route('student.accounts.show', ['student' => $student->id]);
  }

  /**
   * 個人アカウント表示画面
   */
  public function show(Request $request)
  {
    // 認証しているユーザーのみ表示の場合
    // $student = Auth::user();
    $student = Student::findOrFail($request->route()->parameter('student'));

    // 学部カラー
    if ($student->faculty->id == CommonConstants::FACULTY_CODE['business']) {
      $faculty_bg_color = 'bg-business';
    } else if ($student->faculty->id == CommonConstants::FACULTY_CODE['anime']) {
      $faculty_bg_color = 'bg-anime';
    } else {
      $faculty_bg_color = 'bg-ict';
    }

    return view('student.accounts.show', compact('student', 'faculty_bg_color'));
  }

  /**
   * ブックマーク一覧表示画面
   */
  public function showBookMark(Request $request)
  {
    $thread_status = $request->input('thread_status', 0);
    $search_word = $request->input('search_word', '');

    $student = Student::with([
      'bookmark_threads' => function ($query) use ($search_word) {
        $query->where('title', 'like', '%' . $search_word . '%')
          ->orderByDesc('created_at');
      },
      'bookmark_threads.status',
      'bookmark_threads.student',
      'bookmark_threads.secondary_category',
    ])->findOrFail(Auth::id());

    $statuses = Status::all();
    $status_code = CommonConstants::STATUS_CODE;
    return view('student.accounts.bookmark', compact('student', 'statuses', 'status_code', 'thread_status', 'search_word'));
  }

  /**
   * ブックマーク登録
   */
  public function registerBookMark(Request $request)
  {
    // スレッドをブックマークに登録
    $user = Auth::user();
    $thread_id_in_url_path = $request->route()->parameter('thread');

    $thread = Thread::findOrFail($thread_id_in_url_path);

    $book_mark = Bookmark::where(['user_id' => $user->id, 'thread_id' => $thread->id])->first();
    // 既存のブックマークになければ、新たに登録
    if (is_null($book_mark)) {
      Bookmark::create([
        'user_id' => $user->id,
        'thread_id' => $thread->id,
      ]);
    } else {
      return back()->with('msg_error', '既に登録しています');
    }
    return redirect()->route('student.threads.show', ['thread' => $thread->id])
      ->with('msg_success', 'ブックマークに登録しました');
  }

  /**
   * 個人のスレッド一覧
   */
  public function showThreads(Request $request)
  {
    $user = Student::findOrFail($request->route()->parameter('student'));
    $threads = Thread::with(['status', 'comments', 'secondary_category.primary_category'])
      ->where('user_id', $user->id)
      ->where(function ($query) use ($user) {
        // 認証済みユーザのページではない場合
        if ($user->id != Auth::id())
          // 匿名スレッドでないスレッドのみを取得
          $query->where('is_anonymous', 0);
      })
      ->orderByDesc('created_at')->get();

    $status_code = CommonConstants::STATUS_CODE;

    return view('student.accounts.threads', compact('user', 'threads', 'status_code'));
  }

  /**
   * 個人のコメント一覧
   */
  public function showComments(Request $request)
  {
    $student_id_in_url_path = $request->route()->parameter('student');
    // Common クラスのインスタンスをビューで用いる
    $common = new CommonConstants;

    // 認証されたユーザ自身の場合は匿名スレッドも含めて一覧表示
    $student = Student::with(['comments' => function ($query) {
      $query->orderByDesc('created_at');
    }, 'comments.thread'])->findOrFail($student_id_in_url_path);
    return view('student.accounts.comments', compact('student', 'common'));
  }

  /**
   * その他
   */
  public function others()
  {
    // カテゴリ一覧表示画面
    // Eager Loading.
    // $primary_categories = PrimaryCategory::with('secondary_categories')->orderBy('sort_order')->get();
    $student = Student::with('faculty')->findOrFail(Auth::id());
    return view('common.bbs.others.index', compact('student'));
  }

  /**
   * API
   */
  public function api()
  {
    $student = Auth::user();
    return view('common.bbs.others.api', compact('student'));
  }

  public function showToken()
  {
    $user = Auth::user();
    $token = $user->api_access_token;
    return view('student.accounts.crud-api-token', compact('user', 'token'));
  }

  public function createToken(Request $request)
  {
    // 既にアクセスキーを保持している場合はエラーメッセージを返却
    if (Auth::user()->api_access_token !== null) {
      return back()->with([
        'msg_error' => '現在有効なアクセスキーを削除後に再発行できます。',
      ]);
    }
    try {
      // アクセスキーの新規作成
      $api_access_token = Str::random(40);
      // dd($api_access_token);
      $user = Auth::user();
      $user->api_access_token = $api_access_token;
      $user->save();
    } catch (Throwable $e) {
      return back()->with([
        'msg_error' => 'もう一度お試しください。',
      ]);
    }
    return redirect()->route('student.showToken', ['student' => $user->id])->with([
      'msg_success' => 'API アクセスキーを作成しました。',
    ]);
  }

  public function deleteToken(Request $request)
  {
    $user = Auth::user();
    $user->api_access_token = null;
    $user->save();
    return redirect()->route('student.showToken', ['student' => $user->id])->with([
      'msg_success' => 'API アクセスキーを削除しました。',
    ]);
  }
}
