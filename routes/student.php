<?php

use App\Http\Controllers\BBS\CommentController;
use App\Http\Controllers\BBS\ThreadController;
use App\Http\Controllers\BBS\CategoryController;
use App\Http\Controllers\BBS\NotificationController;
use App\Http\Controllers\BBS\DirectMessageController;
use App\Http\Controllers\Student\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Student\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Student\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Student\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Student\Auth\NewPasswordController;
use App\Http\Controllers\Student\Auth\PasswordResetLinkController;
use App\Http\Controllers\Student\Auth\RegisteredUserController;
use App\Http\Controllers\Student\Auth\VerifyEmailController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
  return redirect()->route('student.threads.index');
})->middleware('auth:students')->name('dashboard');

/**
 * Thread RESTful Controller
 */
Route::resource('threads', ThreadController::class)
  ->middleware('auth:students')->except(['edit', 'update', 'destroy']);

/**
 * Others
 */
// Route::get('/others', [StudentController::class, 'others'])->middleware('auth:students')->name('others');
Route::prefix('others')->name('others.')->group(function () {
  Route::middleware('auth:students')->group(function () {
    Route::get('/', [StudentController::class, 'others'])->name('index');
    Route::get('/edit-basic-profile', [StudentController::class, 'editBasicProfile'])->name('editBasicProfile');
    Route::get('/add-category', [StudentController::class, 'addCategory'])->name('addCategory');
    Route::get('/api', [StudentController::class, 'api'])->name('api');
  });
});

/**
 * Comment
 */
Route::prefix('threads')->name('threads.')->group(function () {
  // students guard のみアクセスを許可
  Route::middleware('auth:students')->group(function () {

    // 新しいコメントを投稿
    Route::post('/{thread}/new-comment', [CommentController::class, 'store'])
      ->name('comments.store')
      ->where('thread', '[0-9]+');

    // コメント返信画面
    Route::get('/{thread}/reply/{comment}', [CommentController::class, 'createReply'])
      ->name('comments.create-reply')
      ->where(['thread' => '[0-9]+', 'comment' => '[0-9]+']);

    // コメント返信
    Route::post('/{thread}/reply/{comment}', [CommentController::class, 'storeReply'])
      ->name('comments.send-reply')
      ->where(['thread' => '[0-9]+', 'comment' => '[0-9]+']);

    // 新しくブックマークへ登録
    Route::post('/{thread}/new-bookmark', [StudentController::class, 'registerBookMark'])
      ->name('registerBookmark')
      ->where('thread', '[0-9]+');

    // 「回答募集」スレッドの特定のコメントをベストアンサーに登録する
    Route::post('/{thread}/best-answer/{comment}', [CommentController::class, 'bestAnswer'])
      ->name('comments.bestAnswer')->where(['thread' => '[0-9]+', 'comment' => '[0-9]+']);

    // スレッドに「Good」をつける
    Route::post('/{thread}/good', [ThreadController::class, 'registerGoodThread'])
      ->name('registerGoodThread')
      ->where('thread', '[0-9]+');

    // コメントに「Good」をつける
    Route::post('/{thread}/{comment}/good', [CommentController::class, 'registerGoodComment'])
      ->name('comments.registerGoodComment')
      ->where(['thread' => '[0-9]+', 'comment' => '[0-9]+']);

    /**
     * Categories
     */
    Route::prefix('categories')->name('categories.')->group(function () {

      // カテゴリ一覧ページ
      Route::get('/all', [CategoryController::class, 'index'])->name('index');

      // 個別カテゴリページ
      Route::get('/{category}', [CategoryController::class, 'show'])
        ->name('show')->where('category', '[0-9]+');
    });
  });
});

/**
 * 個人アカウント設定
 */
Route::middleware('auth:students')->group(function () {
  // アカウント情報設定画面
  Route::get('/{student}/edit', [StudentController::class, 'edit'])
    ->name('accounts.edit')
    ->where('student', '[0-9]+');

  // アカウント情報を設定する
  Route::post('{student}/update', [StudentController::class, 'update'])
    ->name('accounts.update');

  // アカウント表示画面
  Route::get('/{student}', [StudentController::class, 'show'])
    ->name('accounts.show')
    ->where('student', '[0-9]+');

  // 通知一覧
  Route::get('/{student}/notification', [NotificationController::class, 'index'])
    ->name('notification')
    ->where('student', '[0-9]+');

  // ダイレクトメッセージ
  Route::get('/{student}/direct', [DirectMessageController::class, 'index'])
    ->name('direct.index')
    ->where('student', '[0-9]+');

  // 新規ダイレクトメッセージ作成画面
  Route::get('/{student}/new-direct-message', [DirectMessageController::class, 'create'])
    ->name('direct.create')
    ->where('student', '[0-9]+');

  // 個人ブックマーク一覧
  Route::get('/{student}/bookmark', [StudentController::class, 'showBookMark'])
    ->name('bookmark')
    ->where('student', '[0-9]+');

  // 過去のスレッド一覧
  Route::get('/{student}/threads', [StudentController::class, 'showThreads'])
    ->name('threads')->where('student', '[0-9]+');

  // 過去のコメント一覧
  Route::get('/{student}/comments', [StudentController::class, 'showComments'])
    ->name('comments')
    ->where('student', '[0-9]+');

  // APIトークンの参照
  Route::get('/{student}/api-key', [StudentController::class, 'showToken'])
    ->name('showToken')
    ->where('student', '[0-9]+');

  // API利用トークンの発行
  Route::post('/{student}/api-key', [StudentController::class, 'createToken'])
    ->name('createToken')
    ->where('student', '[0-9]+');

  // API利用トークンの削除
  Route::post('/{student}/api-key/delete', [StudentController::class, 'deleteToken'])
    ->name('deleteToken')
    ->where('student', '[0-9]+');
});

/**
 * Authentication.
 */
Route::get('/register', [RegisteredUserController::class, 'create'])
  ->middleware('guest')
  ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
  ->middleware('guest');


Route::get('/login', function () {
  return redirect()->route('common.welcome');
})->middleware('guest')->name('login');

// Route::get('/login', [AuthenticatedSessionController::class, 'create'])
//   ->middleware('guest')
//   ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
  ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
  ->middleware('guest')
  ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
  ->middleware('guest')
  ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
  ->middleware('guest')
  ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
  ->middleware('guest')
  ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
  ->middleware('auth:students')
  ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
  ->middleware(['auth:students', 'signed', 'throttle:6,1'])
  ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
  ->middleware(['auth:students', 'throttle:6,1'])
  ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
  ->middleware('auth:students')
  ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
  ->middleware('auth:students');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
  ->middleware('auth:students')
  ->name('logout');
