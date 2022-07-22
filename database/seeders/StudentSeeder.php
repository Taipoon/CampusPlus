<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('students')->insert([

      [
        'last_name' => '平山',
        'first_name' => '泰暉',
        'last_name_kana' => 'ヒラヤマ',
        'first_name_kana' => 'タイキ',
        'email' => 'hirayama@dev',
        'faculty_id' => Faculty::where('faculty_name', '情報学部')->first()->id,
        'password' => Hash::make('password123'),
        'created_at' => now(),
      ],
      [
        'last_name' => '情報',
        'first_name' => '太郎',
        'last_name_kana' => 'ジョウホウ',
        'first_name_kana' => 'タロウ',
        'email' => 'joho@dev',
        'faculty_id' => Faculty::where('faculty_name', '情報学部')->first()->id,
        'password' => Hash::make('password123'),
        'created_at' => now(),
      ],
      [
        'last_name' => '事創',
        'first_name' => '次郎',
        'last_name_kana' => 'ジソウ',
        'first_name_kana' => 'ジロウ',
        'email' => 'jisou@dev',
        'faculty_id' => Faculty::where('faculty_name', '事業創造学部')->first()->id,
        'password' => Hash::make('password123'),
        'created_at' => now(),
      ],
      [
        'last_name' => '兄目',
        'first_name' => '看太郎',
        'last_name_kana' => 'アニメ',
        'first_name_kana' => 'ミタロウ',
        'email' => 'anime@dev',
        'faculty_id' => Faculty::where('faculty_name', 'アニメ・マンガ学部')->first()->id,
        'password' => Hash::make('password123'),
        'created_at' => now(),
      ],
    ]);
  }
}
