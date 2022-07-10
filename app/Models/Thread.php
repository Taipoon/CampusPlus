<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'user_id',
    'sort_order',
    'secondary_category_id',
    'status_id',
    'is_anonymous',
    'best_answer_comment_id',
  ];
  /**
   * students との関連
   */
  public function student()
  {
    return $this->belongsTo(Student::class, 'user_id');
  }

  /**
   * secondary_categories との関連
   */
  public function secondary_category()
  {
    return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
  }

  /**
   * statuses との関連
   */
  public function status()
  {
    return $this->belongsTo(Status::class, 'status_id');
  }

  /**
   * comments との関連
   */
  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

  /**
   * Bookmark との関連
   * ブックマークに登録している学生を取得
   */
  public function bookmark_students()
  {
    return $this->belongsToMany(Student::class, 'bookmarks', 'thread_id', 'user_id');
  }

  /**
   * GoodThread との関連
   */
  public function students_who_like_this()
  {
    return $this->belongsToMany(Student::class, 'good_threads', 'user_id', 'thread_id');
  }

  public function notifications()
  {
    return $this->hasMany(Notification::class, 'thread_id');
  }
}
