<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genres')->insert([
            ['id' => 1, 'genre' => 'Pop'],
            ['id' => 2, 'genre' => 'Electronic'],
            ['id' => 3, 'genre' => 'Hip Hop'],
            ['id' => 4, 'genre' => 'R&B'],
            ['id' => 5, 'genre' => 'Latin'],
            ['id' => 6, 'genre' => 'Rock'],
            ['id' => 7, 'genre' => 'Metal'],
            ['id' => 8, 'genre' => 'Country'],
            ['id' => 9, 'genre' => 'Folk/Acoustic'],
            ['id' => 10, 'genre' => 'Classical'],
            ['id' => 11, 'genre' => 'Jazz'],
            ['id' => 12, 'genre' => 'Blues'],
            ['id' => 13, 'genre' => 'Easy Listening'],
            ['id' => 14, 'genre' => 'New Age'],
            ['id' => 15, 'genre' => 'World/Traditional'],
        ]);
    }
}
