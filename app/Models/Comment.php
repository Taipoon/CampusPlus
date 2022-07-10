<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use HasFactory;

  protected $fillable = [
    'text',
    'user_id',
    'thread_id',
    'reply_to',
    'image1',
    'image2',
    'image3',
  ];

  /**
   * students との関連
   */
  public function student()
  {
    return $this->belongsTo(Student::class, 'user_id');
  }

  /**
   * threads との関連
   */
  public function thread()
  {
    return $this->belongsTo(Thread::class);
  }

  /**
   * images との関連
   */
  public function imageFirst()
  {
    return $this->belongsTo(Image::class, 'image1');
  }
  public function imageSecond()
  {
    return $this->belongsTo(Image::class, 'image2');
  }
  public function imageThird()
  {
    return $this->belongsTo(Image::class, 'image3');
  }

  /**
   * GoodComment との関連
   */
  public function students_who_like_this()
  {
    return $this->belongsToMany(Student::class, 'good_comments', 'user_id', 'comment_id');
  }

  public function notifications()
  {
    return $this->hasMany(Notification::class, 'comment_id');
  }
}
