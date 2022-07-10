<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstants;
use App\Models\Comment;
use App\Models\Faculty;
use App\Models\PrimaryCategory;
use App\Models\Status;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

use function PHPSTORM_META\type;

class ApiController extends Controller
{

  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      // key を含まないアクセスはすべてUnauthorized
      $key = $request->key;
      if ($key == null || $key == '' || DB::table('students')->where('api_access_token', $request->key)->doesntExist()) {
        return response()->json([
          'error' => 'Unauthorized',
          'error_description' => 'The API access key is incorrect or not specified',
        ]);
      }
      return $next($request);
    });
  }

  public function threads(Request $request)
  {
    $query = Thread::with([
      'comments:id,text,user_id,thread_id,reply_to,created_at',
      'student:id,last_name,first_name,last_name_kana,first_name_kana,email',
      'secondary_category:id,name,primary_category_id',
      'secondary_category.primary_category:id,name',
    ])->where('is_anonymous', false);

    // IDで絞り込み
    if ($request->has('id')) {
      $thread_id = $request->id;
      $query->where('id', $thread_id);
    }
    // タイトルで絞り込み
    if ($request->has('search')) {
      $search_title = $request->search;
      $query->where('title', 'like', '%' . $search_title . '%');
    }
    // 投稿者で絞り込み
    if ($request->has('userId')) {
      $user_id = $request->userId;
      $query->where('user_id', $user_id);
    }
    // スレッドステータスで絞り込み
    if ($request->has('status')) {
      $thread_status = $request->status;
      if ($thread_status === 'none' || $thread_status === 'required' || $thread_status === 'resolved') {
        $query->where('status_id', CommonConstants::STATUS_CODE[$thread_status]);
      } else {
        return response()->json([
          'error' => 'wrong_parameter',
          'error_description' => 'keyword parameter is not valid',
        ]);
      }
    }
    // 第2カテゴリで絞り込み
    if ($request->has('category')) {
      $category_id = $request->category;
      $query->where('secondary_category_id', $category_id);
    }
    try {
      // 投稿日で絞り込み (指定した日付以降)
      if ($request->has('afterDate')) {
        $afterDate = new Carbon($request->afterDate);
        // dd($afterDate, gettype($afterDate));
        $query->where('created_at', '>=', $afterDate);
      }
      // 投稿日で絞り込み (指定した日付以前)
      if ($request->has('beforeDate')) {
        $beforeDate = new Carbon($request->beforeDate);
        $query->where('created_at', '<', $beforeDate);
      }
      // 投稿日時で絞り込み (指定した日時以降)
      if ($request->has('afterDateTime')) {
        $afterDateTime = str_replace('$', ' ', $request->afterDateTime);
        $afterDateTime = new Carbon($afterDateTime);
        $query->where('created_at', '>=', $afterDateTime);
      }
      // 投稿日時で絞り込み (指定した日時以前)
      if ($request->has('beforeDateTime')) {
        $beforeDateTime = str_replace('$', ' ', $request->beforeDateTime);
        $beforeDateTime = new Carbon($afterDateTime);
        $query->where('created_at', '<', $beforeDateTime);
      }
    } catch (Throwable $e) {
      return response()->json([
        'error' => 'wrong_parameter',
        'error_description' => 'The parameter is not in the specified format',
      ]);
    }

    $thread = $query->get([
      'id',
      'title',
      'user_id',
      'status_id',
      'best_answer_comment_id',
      'secondary_category_id',
      'created_at',
    ]);

    return response()->json([
      'threads' => $thread,
    ]);
  }

  public function comments(Request $request)
  {
    $query = Comment::with([
      'student:id,last_name,first_name,last_name_kana,first_name_kana,email,faculty_id',
      'student.faculty',
      'thread:id,title,user_id,secondary_category_id,status_id,is_anonymous,best_answer_comment_id',
    ]);

    // ID で絞り込み
    if ($request->has('id')) {
      $query->where('id', $request->id);
    }
    // 投稿者で絞り込み
    if ($request->has('userId')) {
      $user_id = $request->userId;
      $query->where('user_id', $user_id);
    }
    // 返信先で絞り込み
    if ($request->has('replyTo')) {
      $reply_to = $request->replyTo;
      $query->where('reply_to', $reply_to);
    }
    // テキストで曖昧検索
    if ($request->has('search')) {
      $search_word = $request->search;
      $query->where('text', 'like', '%' . $search_word . '%');
    }
    try {
      // 投稿日で絞り込み (指定した日付以降)
      if ($request->has('afterDate')) {
        $afterDate = new Carbon($request->afterDate);
        // dd($afterDate, gettype($afterDate));
        $query->where('created_at', '>=', $afterDate);
      }
      // 投稿日で絞り込み (指定した日付以前)
      if ($request->has('beforeDate')) {
        $beforeDate = new Carbon($request->beforeDate);
        $query->where('created_at', '<', $beforeDate);
      }
      // 投稿日時で絞り込み (指定した日時以降)
      if ($request->has('afterDateTime')) {
        $afterDateTime = str_replace('$', ' ', $request->afterDateTime);
        $afterDateTime = new Carbon($afterDateTime);
        $query->where('created_at', '>=', $afterDateTime);
      }
      // 投稿日時で絞り込み (指定した日時以前)
      if ($request->has('beforeDateTime')) {
        $beforeDateTime = str_replace('$', ' ', $request->beforeDateTime);
        $beforeDateTime = new Carbon($afterDateTime);
        $query->where('created_at', '<', $beforeDateTime);
      }
    } catch (Throwable $e) {
      return response()->json([
        'error' => 'wrong_parameter',
        'error_description' => 'The parameter is not in the specified format',
      ]);
    }
    // 選択したカラムをキーにしてソート
    // if ($request->has('sort_by')) {
    //   if ($request->has('sort_order')) {
    //     $sort_order = $request->sort_order ?? 'asc';
    //   }
    //   $sort_by = $request->has('sort_by');
    //   $query->orderBy($sort_by, $sort_order);
    // }

    $comments = $query->get([
      'id',
      'text',
      'user_id',
      'thread_id',
      'reply_to',
      'created_at',
    ]);

    return response()->json([
      'comments' => $comments,
    ]);
  }

  public function categories(Request $request)
  {
    $query = PrimaryCategory::with([
      'secondary_categories:id,name,primary_category_id',
    ]);

    if ($request->has('id')) {
      $primary_category_id = $request->id;
      $query->where('id', $primary_category_id);
    }

    $categories = $query->get(['id', 'name']);
    return response()->json([
      'primary_categories' => $categories,
    ]);
  }

  public function students(Request $request)
  {
    $query = Student::with('faculty');

    // IDで絞り込み
    if ($request->has('id')) {
      $id = $request->id;
      $query->where('id', $id);
    }
    // 学籍番号で絞り込み
    if ($request->has('number')) {
      $number = $request->number;
      $query->where('email', 'like', '%' . $number . '%');
    }
    // 姓で絞り込み
    if ($request->has('lastName')) {
      $last_name = $request->lastName;
      $query->where('last_name', 'like', '%' . $last_name . '%');
    }
    // 名で絞り込み
    if ($request->has('firstName')) {
      $first_name = $request->firstName;
      $query->where('first_name', 'like', '%' . $first_name . '%');
    }
    // 学部で絞り込み
    if ($request->has('faculty')) {
      $faculty = $request->faculty;
      if ($faculty === 'ict' || $faculty === 'business' || $faculty === 'anime') {
        $query->where(['faculty_id' => CommonConstants::FACULTY_CODE[$faculty]]);
      } else {
        return response()->json([
          'error' => 'wrong_parameter',
          'error_description' => 'keyword parameter is not valid'
        ]);
      }
    }
    $students = $query->get([
      'id',
      'last_name',
      'first_name',
      'last_name_kana',
      'first_name_kana',
      'email',
      'faculty_id',
      'profile',
      'twitter',
      'instagram',
      'github',
      'youtube',
      'url',
      'information',
    ]);

    return response()->json([
      'students' => $students,
    ]);
  }

  public function teachers(Request $request)
  {
    $query = Teacher::where('id', '>', 0);
    if ($request->has('id')) {
      $id = $request->id;
      $query->where('id', $id);
    }
    if ($request->has('name')) {
      $name = $request->name;
      $query->where('name', 'like', '%' . $name . '%');
    }
    $teachers = $query->get([
      'id',
      'name',
      'email',
    ]);
    return response()->json([
      'teachers' => $teachers,
    ]);
  }

  public function faculties(Request $request)
  {
    if ($request->has('id')) {
      $id = $request->id;
      $faculties = Faculty::where('id', $id)->get();
    } else {
      $faculties = Faculty::all();
    }

    return response()->json([
      'faculties' => $faculties,
    ]);
  }

  public function status(Request $request)
  {
    $status = Status::all(['id', 'name']);

    return response()->json([
      'status' => $status,
    ]);
  }

  public function create()
  {
    //
  }

  public function store(Request $request)
  {
    //
  }

  public function show($id)
  {
    //
  }

  public function edit($id)
  {
    //
  }

  public function update(Request $request, $id)
  {
    //
  }

  public function destroy($id)
  {
    //
  }
}
