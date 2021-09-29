<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $genres = ['Боевик',
            'Вестерн',
            'Гангстерский фильм',
            'Детектив',
            'Драма',
            'Исторический фильм',
            'Комедия',
            'Мелодрама',
            'Музыкальный фильм',
            'Нуар',
            'Политический фильм',
            'Приключенческий фильм',
            'Сказка',
            'Трагедия',
            'Трагикомедия',];

        foreach ($genres as $genre) {
            DB::table('genres')->insert([
                'title' => $genre,
            ]);
        }
    }
}
