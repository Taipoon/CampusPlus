<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectMessageContent extends Model
{
  use HasFactory;

  protected $fillable = [
    'content',
    'sender_id',
    'recipient_id',
    'direct_message_id',
  ];

  public function direct_message()
  {
    return $this->belongsTo(DirectMessage::class, 'direct_message_id');
  }

  public function sender()
  {
    return $this->belongsTo(Student::class, 'sender_id');
  }

  public function recipient()
  {
    return $this->belongsTo(Student::class, 'recipient_id');
  }
}
