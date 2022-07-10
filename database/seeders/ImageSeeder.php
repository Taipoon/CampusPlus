<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('images')->insert([
      [
        'user_id' => 1,
        'title' => 'sample1.jpg',
      ],
      [
        'user_id' => 1,
        'title' => 'sample2.jpg',
      ],
      [
        'user_id' => 1,
        'title' => 'sample3.jpg',
      ],
      [
        'user_id' => 1,
        'title' => 'sample4.jpg',
      ],
      [
        'user_id' => 1,
        'title' => 'sample5.jpg',
      ],
      [
        'user_id' => 1,
        'title' => 'sample6.jpg',
      ],
    ]);
  }
}
