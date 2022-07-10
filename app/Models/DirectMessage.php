<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'notification_id',
  ];

  public function student()
  {
    return $this->belongsTo(Student::class, 'user_id');
  }

  public function contents()
  {
    return $this->hasMany(DirectMessageContent::class, 'direct_message_id');
  }
}
