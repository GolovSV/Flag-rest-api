<?php

namespace App\Filters;

use Illuminate\Support\Facades\DB;

class FilmFilters extends QueryFilter
{
    public function genre($parameter)
    {
        return $this->builder
            ->LeftJoin('genres', 'films.genre_id', '=', 'genres.id')
            ->select('films.*')
            ->where('genres.title', 'like', "%$parameter%");
    }

    public function actor($parameter)
    {
        return $this->builder
            ->join('actor_film', 'films.id', '=', 'actor_film.film_id')
            ->join('actors', 'actor_film.actor_id', '=', 'actors.id')
            ->select('films.*')
            ->where('actors.name', 'like', "%$parameter%");
    }

    public function sort($order = 'asc')
    {
        return $this->builder->orderBy('films.title', $order);
    }
}
