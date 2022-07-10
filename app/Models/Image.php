<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'title',
    'filename',
  ];

  /**
   * comments との関連
   */
  public function student()
  {
    return $this->hasMany(Student::class, 'user_id');
  }
}
