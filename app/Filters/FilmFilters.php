<?php

namespace App\Filters;

use Illuminate\Support\Facades\DB;

class FilmFilters extends QueryFilter
{
    public function genre($parameter)
    {
        return $this->builder->whereRelation('genre', 'title', 'like', "%$parameter%");
    }

    public function actor($parameter)
    {
        return $this->builder->whereRelation('actors', 'name', 'like', "%$parameter%");
    }

    public function sort($order = 'asc')
    {
        return $this->builder->orderBy('films.title', $order);
    }
}
