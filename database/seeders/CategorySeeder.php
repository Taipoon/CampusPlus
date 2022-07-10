<?php

namespace Database\Seeders;

use App\Constants\CommonConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\Footnote\Node\FootnoteRef;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $i = 1;
    foreach (CommonConstants::CATEGORIES as $primary_category => $second_categories) {
      DB::table('primary_categories')->insert([
        'name' => $primary_category,
        'sort_order' => 1,
      ]);
      foreach ($second_categories as $secondary_category) {
        DB::table('secondary_categories')->insert([
          'name' => $secondary_category,
          'sort_order' => 1,
          'primary_category_id' => $i,
        ]);
      }
      $i++;
    }
  }
}
