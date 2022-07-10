<?php

namespace App\Http\Controllers\BBS;

use App\Constants\CommonConstants;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\GoodComment;
use App\Models\Image;
use App\Models\Notification;
use App\Models\Thread;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CommentController extends Controller
{
  public function store(Request $request)
  {
    // 新規にコメントを投稿する
    $request->validate([
      'text' => 'required|string|max:700',
      'image' => 'image|mimes:jpg,jpeg,png|max:2048',
    ]);
    // 文頭・文末の全角スペースを含んだ空白文字を削除
    $parsedText = CommonConstants::mbTrim($request->text);
    if (empty($parsedText)) {
      return back()->withErrors('何も入力されていないように見えますよね。');
    }

    // URLのパラメータが不適切であったらエラーメッセージを表示して直前のページへ戻す
    $thread_id_in_url_path = $request->route()->parameter('thread');
    if (!preg_match('/[0-9]+/', $thread_id_in_url_path)) {
      return back()->withErrors('不正な操作です。');
    }
    // 認証済みユーザーのIDを取得
    $user_id = Auth::id();

    try {
      DB::transaction(function () use ($request, $user_id) {
        // 画像が存在しない場合は外部キーにnullを設定
        if (is_null($request->file('image'))) {
          $image_id = null;
        } else {
          /* 画像が存在するとき 16:9 にリサイズして保存 */
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
          'thread_id' => $request->route()->parameter('thread'),
          'reply_to' => null,
          'image1' => $image_id,
        ]);
      });
    } catch (Throwable $e) {
      Log::error($e);
      throw $e;
    }
    // 二重投稿防止
    $request->session()->regenerateToken();

    return redirect()->route('student.threads.show', ['thread' => $request->route()->parameter('thread')]);
  }

  public function createReply($thread_id, $comment_id)
  {
    $comment = Comment::findOrFail($comment_id);
    // 特定のコメントに対して返信する画面を表示
    return view('common.bbs.comments.create-reply', compact('comment'));
  }

  public function storeReply(Request $request)
  {
    $user_id = Auth::id();
    $reply_to_comment = Comment::findOrFail($request->route()->parameter('comment'));
    try {
      DB::transaction(function () use ($user_id, $request, $reply_to_comment) {
        // 画像が存在しない場合は外部キーにnullを設定
        if (is_null($request->file('image'))) {
          $image_id = null;
        } else {
          /* 画像が存在するとき 16:9 にリサイズして保存 */
          $resized_image_filename = ImageService::commentImageUpload($request->file('image'), 'comments');
          $uploaded_image = Image::create([
            'user_id' => $user_id,
            'title' => '',
            'filename' => $resized_image_filename,
          ]);
          $image_id = $uploaded_image->id;
        }
        $created_reply = Comment::create([
          'text' => $request->text,
          'user_id' => $user_id,
          'thread_id' => $request->route()->parameter('thread'),
          'reply_to' => $reply_to_comment->id,
          'image1' => $image_id,
        ]);
        Notification::create([
          'from_user_id' => $user_id,
          'to_user_id' => $reply_to_comment->student->id,
          'type' => CommonConstants::NOTIFICATION_TYPES['reply'],
          'thread_id' => $reply_to_comment->thread_id,
          'comment_id' => $reply_to_comment->id,
          'reply_comment_id' => $created_reply->id,
          'is_anonymous' => $reply_to_comment->thread->is_anonymous,
        ]);
      });
    } catch (Throwable $e) {
      Log::error($e);
      throw $e;
    }
    // 二重投稿防止
    $request->session()->regenerateToken();

    return redirect()->route('student.threads.show', ['thread' => $request->route()->parameter('thread')]);
  }

  public function registerGoodComment(Request $request)
  {
    $comment = Comment::findOrFail($request->route()->parameter('comment'));
    $good_comment = GoodComment::where(['user_id' => Auth::id(), 'comment_id' => $comment->id])->first();
    // 既存のブックマークになければ、新たに登録
    if (is_null($good_comment)) {
      try {
        DB::transaction(function () use ($comment) {
          GoodComment::create([
            'user_id' => Auth::id(),
            'comment_id' => $comment->id,
          ]);
          Notification::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $comment->student->id,
            'type' => CommonConstants::NOTIFICATION_TYPES['good_comment'],
            'comment_id' => $comment->id,
            'thread_id' => $comment->thread_id,
          ]);
        });
      } catch (Throwable $e) {
        Log::error($e);
        throw $e;
      }
    } else {
      return back()->with('msg_error', '既に登録しています');
    }
    return redirect()->back()->with('msg_success', 'いいね！しました');
  }

  /**
   * ベストアンサーに登録し、スレッドを解決済みにする
   * 今回は自分のスレッドの中で自分のコメントにもベストアンサーをつけることを許可する
   */
  public function bestAnswer(Request $request)
  {
    $thread = Thread::findOrFail($request->route()->parameter('thread'));
    $comment = Comment::findOrFail($request->route()->parameter('comment'));
    // 回答募集中のスレッドであり、かつ、スレッドを投稿した人であれば処理を続行
    if ($thread->id != Auth::id() && $thread->status_id != CommonConstants::REQUEST_FOR_ANSWER) {
      abort(403);
    }
    // コメントがスレッドに所属することを確認
    if ((int)$comment->thread_id != $thread->id) {
      abort(404);
    }
    // ベストアンサーに登録してスレッドを解決済みにする
    $thread->best_answer_comment_id = $comment->id;
    $thread->status_id = CommonConstants::RESOLVED;
    $thread->save();

    return redirect()->route('student.threads.show', ['thread' => $thread->id]);
  }
}
