<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_types')->insert([
            ['id' => 1, 'user_type' => 'listener'],
            ['id' => 2, 'user_type' => 'artist'],
            ['id' => 3, 'user_type' => 'admin'],
            ['id' => 4, 'user_type' => 'superadmin'],
        ]);
    }
}
