<?php

namespace App\Http\Controllers\BBS;

use App\Constants\CommonConstants;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\GoodThread;
use App\Models\Image;
use App\Models\Notification;
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use App\Models\Status;
use App\Models\Thread;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ThreadController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:students');
  }

  public function index(Request $request)
  {
    // 検索パラメータ
    $category = $request->input('category', 0);
    $search_word = $request->input('search_word', '');
    $thread_status = $request->input('thread_status', 0);
    $is_anonymous = $request->merge([
      'is_anonymous' => $request->boolean('is_anonymous') ? 1 : 0,
    ])->input('is_anonymous');

    // スレッド一覧の取得
    $threads = Thread::with([
      'student', 'status', 'secondary_category'
    ])
      ->where(function ($query) use ($search_word, $category, $thread_status, $is_anonymous) {
        if ($search_word !== '') {
          $query->where('title', 'like', '%' . $search_word . '%');
        }
        if ($category != 0) {
          $query->where('secondary_category_id', $category);
        }
        if ($thread_status != 0) {
          $query->Where('status_id', $thread_status);
        }
        if ($is_anonymous) {
          $query->Where('is_anonymous', $is_anonymous);
        }
      })
      ->orderByDesc('created_at')->paginate(20);

    // 最終ログイン日時を取得
    $last_login_at = Carbon::parse(Auth::user()->last_login_at);

    // カテゴリ一覧を取得
    $primary_categories = PrimaryCategory::with('secondary_categories')->orderBy('sort_order')->get();

    // スレッドの状態一覧を取得
    $statuses = Status::all();
    $status_code = CommonConstants::STATUS_CODE;

    // 未読通知の数を取得
    $unread_notifications_count = DB::table('notifications')->where('to_user_id', '=', Auth::id())
      ->Where('is_already_read', '=', 0)->count();

    return view(
      'common.bbs.index',
      compact(
        'threads',
        'status_code',
        'last_login_at',
        'primary_categories',
        'statuses',
        'search_word',
        'thread_status',
        'category',
        'is_anonymous',
        'unread_notifications_count',
      )
    );
  }

  public function create()
  {
    // 新規スレッド作成画面
    $primary_categories = PrimaryCategory::with('secondary_categories')->orderBy('sort_order')->get();
    return view('common.bbs.create', compact('primary_categories'));
  }

  public function store(Request $request)
  {
    // 「回答を募集するか」どうか
    $request->merge([
      'request_for_answer' => $request->boolean('request_for_answer') ? 1 : 0,
    ]);
    // 匿名スレッドにするかどうか
    $request->merge([
      'is_anonymous' => $request->boolean('is_anonymous') ? 1 : 0,
    ]);

    // 新規スレッド作成
    $request->validate([
      'title' => 'required|string|max:100',
      'text' => 'required|string|max:2000',
      'category' => 'required|numeric',
      'request_for_answer' => 'nullable|boolean',
      'is_anonymous' => 'nullable|boolean',
      'image' => 'image|mimes:jpg,jpeg,png|max:10240',
    ]);
    if ($request->request_for_answer === 1) {
      $status = CommonConstants::REQUEST_FOR_ANSWER;
    } else {
      $status = CommonConstants::NOT_SPECIFIED;
    }

    $user_id = Auth::id();
    try {
      $new_thread = DB::transaction(function () use ($request, $status, $user_id) {
        $new_thread = Thread::create([
          'title' => $request->title,
          'user_id' => $user_id,
          'sort_order' => 1,
          'secondary_category_id' => $request->category,
          'status_id' => $status,
          'is_anonymous' => $request->is_anonymous,
        ]);
        if (is_null($request->file('image'))) {
          $image_id = null;
        } else {
          /* 画像を 16:9 にリサイズして保存 */
          $resized_image_filename = ImageService::commentImageUpload($request->file('image'), 'comments');
          $uploaded_image = Image::create([
            'user_id' => $user_id,
            'title' => '',
            'filename' => $resized_image_filename,
          ]);
          $image_id = $uploaded_image->id;
        }
        Comment::create([
          'text' => $request->text,
          'user_id' => $user_id,
          'thread_id' => $new_thread->id,
          'image1' => $image_id,
        ]);
        return $new_thread;
      });
    } catch (Throwable $e) {
      Log::error($e);
      throw $e;
    }

    // 二重投稿防止
    $request->session()->regenerateToken();
    return redirect()->route('student.threads.show', ['thread' => $new_thread->id]);
  }

  public function show($id)
  {
    // 個別スレッド画面を表示
    $thread = Thread::findOrFail($id);

    // スレッドの第1カテゴリ・第2カテゴリを取得
    $secondary_category = SecondaryCategory::findOrFail($thread->secondary_category_id);
    $primary_category = PrimaryCategory::findOrFail($secondary_category->primary_category_id);

    $comments = Comment::with('student', 'imageFirst', 'likes')->where('thread_id', $id)->orderBy('created_at')->get();

    $test_comments = Comment::where('thread_id', $id)->orderBy('created_at')->get();

    if ($thread->status_id == CommonConstants::REQUEST_FOR_ANSWER) {
      $tag = "【回答募集】";
      $tag_color = "text-red-500";
    } else if ($thread->status_id == CommonConstants::RESOLVED) {
      $tag = "【解決済み】";
      $tag_color = "text-blue-500";
    } else {
      $tag = "";
      $tag_color = "";
    }

    $status_code = CommonConstants::STATUS_CODE;

    return view('common.bbs.show', compact(
      'thread',
      'primary_category',
      'secondary_category',
      'comments',
      'tag',
      'tag_color',
      'status_code',
    ));
  }

  public function registerGoodThread(Request $request)
  {
    $user = Auth::user();
    $thread = Thread::findOrFail($request->route()->parameter('thread'));
    $good_thread = GoodThread::where(['user_id' => $user->id, 'thread_id' => $thread->id])->first();
    if (is_null($good_thread)) {
      try {
        DB::transaction(function () use ($user, $thread) {
          GoodThread::create([
            'user_id' => $user->id,
            'thread_id' => $thread->id,
          ]);
          Notification::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $thread->student->id,
            'type' => CommonConstants::NOTIFICATION_TYPES['good_thread'],
            'thread_id' => $thread->id,
          ]);
        });
      } catch (Throwable $e) {
        Log::error($e);
        throw $e;
      }
      return redirect()->back()->with('msg_success', 'いいね！しました');
    }
    return back()->with('msg_error', '既にいいね！しています');
  }
}
