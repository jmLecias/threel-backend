<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisibilityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('visibility_types')->insert([
            ['id' => 1, 'visibility' => 'private'],
            ['id' => 2, 'visibility' => 'public'],
        ]);
    }
}
