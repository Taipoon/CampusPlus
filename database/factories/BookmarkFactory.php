<?php

namespace Database\Factories;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookmarkFactory extends Factory
{
  public function definition()
  {
    $thread = Thread::factory()->create();
    return [
      'user_id' => 1,
      'thread_id' => $thread->id,
    ];
  }
}
