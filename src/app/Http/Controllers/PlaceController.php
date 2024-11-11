<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Traits\DebugHelper;

class PlaceController extends Controller
{
    use DebugHelper;

    public function index()
    {
        $places = Place::latest()->paginate(5);
        return view('places.index', compact('places'));
    }

    public function create()
    {
        return view('places.create');
    }

    public function store(StorePlaceRequest $request)
    {
        $validated = $request->validated();
        Place::create($validated);
        return redirect()->route('places.index');
    }

    public function show(Place $place)
    {
        return view('places.show', compact('place'));
    }

    public function edit(Place $place)
    {
        return view('places.edit', compact('place'));
    }

    public function update(UpdatePlaceRequest $request, Place $place)
    {
        $place->update($request->validated());
        return redirect()->route('places.index');
    }

    public function destroy(Place $place)
    {
        $place->delete();
        return redirect()->route('places.index');
    }
}
