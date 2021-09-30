<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActorRequest;
use App\Http\Resources\ActorResource;
use App\Models\Actor;

use Illuminate\Http\Request;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(ActorResource::collection(Actor::all()));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreActorRequest $request)
    {
        $actor = Actor::firstOrCreate($request->all());
        return response()->json(new ActorResource(Actor::find($actor->id)), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Actor $actor)
    {
        return response()->json(new ActorResource(Actor::find($actor->id)));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreActorRequest $request, Actor $actor)
    {
        $actor->update($request->all());
        return response()->json(new ActorResource(Actor::find($actor->id)));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Actor $actor)
    {
        $actor->delete();
        return response()->json(null, 204);
    }
}
