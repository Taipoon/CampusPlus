<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('comments')->insert([
      [
        'title' => 'これは初めてのコメントです。',
        'contents' => 'これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。',
        'user_id' => 1,
        'thread_id' => 1,
        'image1' => 1,
        'image2' => 2,
        'image3' => 3,
        'created_at' => Carbon::now(),
      ],
      [
        'title' => 'これは2つ目のコメントです。',
        'contents' => 'これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。',
        'user_id' => 1,
        'thread_id' => 1,
        'image1' => 1,
        'image2' => 2,
        'image3' => 3,
        'created_at' => Carbon::now(),
      ],
      [
        'title' => 'これは3つ目のコメントです。',
        'contents' => 'これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。',
        'user_id' => 1,
        'thread_id' => 1,
        'image1' => 1,
        'image2' => 2,
        'image3' => 3,
        'created_at' => Carbon::now(),
      ],
    ]);
  }
}
