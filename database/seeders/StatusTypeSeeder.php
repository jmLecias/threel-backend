<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_types')->insert([
            ['id' => 1, 'status_type' => 'active'],
            ['id' => 2, 'status_type' => 'pending verification'],
            ['id' => 3, 'status_type' => 'deactivated'],
        ]);
    }
}
