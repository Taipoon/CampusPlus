<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'thread_id',
  ];

  /**
   * students との関連
   */
  public function students()
  {
    return $this->hasMany(Student::class, 'user_id');
  }

  /**
   * threads との関連
   */
  public function threads()
  {
    return $this->hasMany(Thread::class, 'thread_id');
  }
}
