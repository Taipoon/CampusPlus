<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
  use HasFactory;

  /**
   * threads との関連
   */
  public function threads()
  {
    return $this->hasMany(Thread::class);
  }
}
