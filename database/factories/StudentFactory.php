<?php

namespace Database\Factories;

use App\Constants\CommonConstants;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class StudentFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'last_name' => $this->faker->lastName,
      'first_name' => $this->faker->firstName,
      'last_name_kana' => $this->faker->lastKanaName,
      'first_name_kana' => $this->faker->firstKanaName,
      'email' => $this->faker->unique()->safeEmail,
      'faculty_id' => $this->faker->numberBetween(CommonConstants::ICT, CommonConstants::ANIME),
      'profile' => $this->faker->realText(100),
      'twitter' => $this->faker->userName,
      'instagram' => $this->faker->userName,
      'github' => $this->faker->userName,
      'url' => $this->faker->url,
      'information' => $this->faker->realText(200),
      'password' => Hash::make('password123'),
    ];
  }
}
