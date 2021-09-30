<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(GenreResource::collection(Genre::all()));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreGenreRequest $request)
    {
        $genre = Genre::firstOrCreate($request->all());
        return response()->json(new GenreResource(Genre::find($genre->id)), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Genre $genre)
    {
        return response()->json(new GenreResource(Genre::find($genre->id)));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreGenreRequest $request, Genre $genre)
    {
        $genre->update($request->all());
        return response()->json(new GenreResource(Genre::find($genre->id)));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->json(null, 204);
    }
}
