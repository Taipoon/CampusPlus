<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::name('api.')->group(function () {
  // thread 一覧
  Route::get('/threads', [ApiController::class, 'threads'])->name('threads');
  // comment 一覧
  Route::get('/comments', [ApiController::class, 'comments'])->name('comments');
  // student 一覧
  Route::get('/students', [ApiController::class, 'students'])->name('students');
  // teacher 一覧
  Route::get('/teachers', [ApiController::class, 'teachers'])->name('teachers');
  // category 一覧
  Route::get('/categories', [ApiController::class, 'categories'])->name('categories');
  // faculty 一覧
  Route::get('/faculties', [ApiController::class, 'faculties'])->name('faculties');
  // status 一覧
  Route::get('/status', [ApiController::class, 'status'])->name('status');
  // Unauthenticated
  Route::get('/unauthenticated', function () {
    return view('common.bbs.apis.unauthenticated');
    // abort(401);
  })->name('unauthenticated');
});
