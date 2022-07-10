<?php

namespace Database\Seeders;

use App\Constants\CommonConstants;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThreadSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('threads')->insert([
      [
        'title' => 'これは初めての投稿です。',
        'user_id' => 1,
        'sort_order' => 1,
        'secondary_category_id' => 1,
        'status_id' => 1,
        'created_at' => new Carbon(),
      ],
      [
        'title' => 'データベースのcursorの課題',
        'user_id' => 2,
        'sort_order' => 1,
        'secondary_category_id' => 1,
        'status_id' => 2,
        'created_at' => new Carbon(),
      ],
      [
        'title' => 'phpMyAdminが開けない',
        'user_id' => 3,
        'sort_order' => 1,
        'secondary_category_id' => 2,
        'status_id' => CommonConstants::RESOLVED,
        'created_at' => new Carbon(),
      ],
    ]);
  }
}
