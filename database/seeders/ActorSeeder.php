<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Film;
use Illuminate\Database\Seeder;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actors = Actor::factory()
            ->count(50)
            ->create();

        foreach ($actors as $actor) {
            $arr = $this->random_array(rand(1, 3), 1, rand(1, Film::count()));
            $actor->films()->sync($arr);
        }

    }

    function random_array($n, $min, $max)
    {
        return array_map(function () use ($min, $max) {
            return mt_rand($min, $max);
        }, range(1, $n));
    }
}
