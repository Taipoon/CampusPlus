<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryCategory extends Model
{
  use HasFactory;

  /**
   * primary_categories との関連
   */
  public function primary_category()
  {
    return $this->belongsTo(PrimaryCategory::class);
  }

  /**
   * threads との関連
   */
  public function threads()
  {
    return $this->hasMany(Thread::class);
  }
}
