<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UploadTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('upload_types')->insert([
            ['id' => 1, 'upload_type' => 'music'],
            ['id' => 2, 'upload_type' => 'podcast'],
            ['id' => 3, 'upload_type' => 'videocast'],
        ]);
    }
}
