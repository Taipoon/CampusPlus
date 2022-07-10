<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryCategory extends Model
{
  use HasFactory;

  /**
   * secondary_categories との関連
   */
  public function secondary_categories()
  {
    return $this->hasMany(SecondaryCategory::class);
  }
}
