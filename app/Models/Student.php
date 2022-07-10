<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
  use HasFactory;
  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'last_name',
    'first_name',
    'last_name_kana',
    'first_name_kana',
    'email',
    'faculty_id',
    'profile',
    'profile_image_filename',
    'icon_image_filename',
    'twitter',
    'instagram',
    'github',
    'youtube',
    'url',
    'information',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  /**
   * faculties との関連
   */
  public function faculty()
  {
    return $this->belongsTo(Faculty::class);
  }

  /**
   * threads との関連
   */
  public function threads()
  {
    return $this->hasMany(Thread::class, 'user_id');
  }

  /**
   * comments との関連
   */
  public function comments()
  {
    return $this->hasMany(Comment::class, 'user_id');
  }

  /**
   * Bookmark との関連
   * ブックマークに登録しているスレッドを取得
   */
  public function bookmark_threads()
  {
    return $this->belongsToMany(Thread::class, 'bookmarks', 'user_id', 'thread_id');
  }

  /**
   * GoodComment との関連
   */
  public function good_comments()
  {
    return $this->belongsToMany(Comment::class, 'good_comments', 'user_id', 'comment_id');
  }

  /**
   * GoodThread との関連
   */
  public function good_threads()
  {
    return $this->belongsToMany(Thread::class, 'good_threads', 'user_id', 'thread_id');
  }

  public function sent_notifications()
  {
    return $this->hasMany(Notification::class, 'to_user_id');
  }

  public function received_notifications()
  {
    return $this->hasMany(Notification::class, 'from_user_id');
  }

  public function direct_messages()
  {
    return $this->hasMany(DirectMessage::class, 'user_id');
  }
}
