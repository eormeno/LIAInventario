<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Http\Requests\PlaceRequest;
use App\Traits\DebugHelper;
use App\Traits\ToastTrigger;

class PlaceController extends Controller
{
    use DebugHelper, ToastTrigger;

    public function index()
    {
        $places = Place::latest()->paginate(5);
        return view('places.index', compact('places'));
    }

    public function create()
    {
        return view('places.create');
    }

    public function store(PlaceRequest $request)
    {
        // Validación y creación
        $validated = $request->validated();
        Place::create($validated);

        // Mensaje de confirmación
        $this->infoToast('Lugar creado exitosamente');
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

    public function update(PlaceRequest $request, Place $place)
    {
        // Validación y actualización
        $place->update($request->validated());

        // Mensaje de confirmación
        $this->infoToast('Lugar actualizado exitosamente');
        return redirect()->route('places.index');
    }

    public function destroy(Place $place)
    {
        $place->delete();

        // Mensaje de confirmación
        $this->successToast('Lugar eliminado exitosamente');
        return redirect()->route('places.index');
    }
}
