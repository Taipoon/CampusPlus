<?php

namespace Database\Seeders;

use App\Constants\CommonConstants;
use App\Models\Bookmark;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory(10)->create();
    $this->call([
      // マスタテーブル
      FacultySeeder::class,
      CategorySeeder::class,
      StatusSeeder::class,
      StudentSeeder::class, // 開発用5アカウントだけ追加
      TeacherSeeder::class, // 開発用教員アカウント
      // ImageSeeder::class,
    ]);

    /* Student と Thread は CommentFactory 内で実行 */

    // Student::factory(Common::MAX_STUDENTS)->create();
    // Thread::factory(Common::MAX_THREADS)->create();
    Comment::factory(CommonConstants::MAX_COMMENTS)->create();
    // Bookmark::factory(50)->create();
  }
}
