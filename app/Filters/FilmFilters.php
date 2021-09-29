<?php

namespace App\Filters;

class FilmFilters extends QueryFilter
{
    public function genre($id)
    {
        return $this->builder->where('genre_id', $id);
    }

    public function actor($actorId)
    {
        return $this->builder->join('actor_film', 'films.id', '=', 'actor_film.film_id')->select('films.*')->where('actor_id', $actorId);
    }


    public function sort($order = 'asc')
    {
        return $this->builder->orderBy('title', $order);
    }
}
