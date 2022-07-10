<?php

namespace Database\Factories;

use App\Constants\CommonConstants;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    // $student = Student::factory()->create();
    return [
      'title' => $this->faker->realText(CommonConstants::MAX_THREAD_TITLE),
      // 'user_id' => $this->faker->numberBetween(1, Common::MAX_STUDENTS),
      'user_id' => 2,
      'sort_order' => 1,
      'secondary_category_id' => $this->faker->numberBetween(1, 18),
      'status_id' => $this->faker->numberBetween(CommonConstants::NOT_SPECIFIED, CommonConstants::RESOLVED),
      'is_anonymous' => $this->faker->boolean,
    ];
  }
}
