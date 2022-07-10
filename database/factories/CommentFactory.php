<?php

namespace Database\Factories;

use App\Constants\CommonConstants;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
  public function definition()
  {
    $thread = Thread::factory()->create();
    return [
      'text' => $this->faker->realText(140),
      // 'user_id' => $this->faker->numberBetween(1, Common::MAX_STUDENTS),
      // 'user_id' => $thread->user_id,
      'user_id' => 2,
      // 'thread_id' => $this->faker->numberBetween(1, Common::MAX_THREADS),
      'thread_id' => $thread->id,
      'reply_to' => null,
    ];
  }
}
