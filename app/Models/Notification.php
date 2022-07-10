<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  use HasFactory;

  protected $fillable = [
    'from_user_id',
    'to_user_id',
    'type',
    'comment_id',
    'reply_comment_id',
    'thread_id',
    'direct_message_id',
    'is_already_read',
    'is_anonymous',
  ];

  public function sender()
  {
    return $this->belongsTo(Student::class, 'from_user_id');
  }

  public function recipient()
  {
    return $this->belongsTo(Student::class, 'to_user_id');
  }

  public function thread()
  {
    return $this->belongsTo(Thread::class, 'thread_id');
  }

  public function comment()
  {
    return $this->belongsTo(Comment::class, 'comment_id');
  }

  public function reply_comment()
  {
    return $this->belongsTo(Comment::class, 'reply_comment_id');
  }

  public function direct_message_content()
  {
    return $this->belongsTo(DirectMessageContent::class, 'direct_message_id');
  }
}
