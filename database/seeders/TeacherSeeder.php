<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('teachers')->insert([
      [
        'name' => '教員 太郎',
        'email' => 'kyoin@dev',
        'password' => Hash::make('password123'),
      ],
      [
        'name' => '情報 太郎',
        'email' => 'joho.taro@test.com',
        'password' => Hash::make('password123'),
      ]
    ]);
  }
}
