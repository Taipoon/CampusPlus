<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faculties')->insert([
            [
                'faculty_name' => '情報学部'
            ],
            [
                'faculty_name' => '事業創造学部',
            ],
            [
                'faculty_name' => 'アニメ・マンガ学部'
            ]
        ]);
    }
}
