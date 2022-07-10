<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('statuses')->insert([
      [
        'name' => '指定なし',
        'remarks' => '',
      ],
      [
        'name' => '回答募集',
        'remarks' => '',
      ],
      [
        'name' => '解決済み',
        'remarks' => '',
      ],
    ]);
  }
}
