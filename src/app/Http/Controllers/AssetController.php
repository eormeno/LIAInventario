<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Traits\DebugHelper;
use App\Traits\ToastTrigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Requests\StoreAssetRequest;
use Illuminate\Support\Arr;

class AssetController extends Controller
{
    use DebugHelper, ToastTrigger;

    /**
     * Mostrar una lista de recursos (activos) con búsqueda.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $assets = Asset::when($search, function ($query, $search) {
            return $query->where('nombre', 'like', "%{$search}%")
                         ->orWhere('codigo_inventario', 'like', "%{$search}%")
                         ->orWhere('codigo_patrimonio', 'like', "%{$search}%")
                         ->orWhere('detalle', 'like', "%{$search}%")
                         ->orWhere('tipo', 'like', "%{$search}%")
                         ->orWhere('observaciones', 'like', "%{$search}%");
        })->paginate(5);

        return view('assets.index', compact('assets', 'search'));
    }

    /**
     * Mostrar el formulario para crear un nuevo activo.
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Guardar un nuevo recurso en la base de datos.
     */
    public function store(StoreAssetRequest $request)
    {
        // Los datos ya están validados en StoreAssetRequest
        $validated = $request->validated();

        // Procesar la imagen, si está presente
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('assets_images', 'public');
            $validated['imagen'] = $imagePath;
        }

        // Asignar fecha actual si no se proporciona 'alta'
        $validated['alta'] = $validated['alta'] ?? Carbon::now()->format('d-m-y');

        // Crear el activo
        Asset::create($validated);

        // Mensaje de éxito
        $this->infoToast('Activo creado exitosamente');
        return redirect()->route('assets.index');
    }

    /**
     * Mostrar un recurso específico.
     */
    public function show(Asset $asset)
    {
        return view('assets.show', compact('asset'));
    }

    /**
     * Mostrar el formulario para editar un recurso.
     */
    public function edit(Asset $asset)
    {
        return view('assets.edit', compact('asset'));
    }

    /**
     * Actualizar un recurso existente en la base de datos.
     */
    public function update(StoreAssetRequest $request, Asset $asset)
    {
        // Los datos ya están validados en StoreAssetRequest
        $validated = $request->validated();

        // Depuración para verificar los datos que llegan al controlador
        //dd($validated);
    
        // Procesar la imagen si hay una nueva
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen existente si aplica
            if ($asset->imagen) {
                Storage::delete('public/' . $asset->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('assets_images', 'public');
        } else {
            // Eliminar la clave 'imagen' para no sobreescribir el valor existente
            $validated = Arr::except($validated, ['imagen']);
        }

    
        // Conservar o actualizar la fecha de 'alta'
        $validated['alta'] = $validated['alta'] ?? $asset->alta->format('Y-m-d');
    
        // Conservar o actualizar la fecha de 'baja'
        $validated['baja'] = $validated['baja'] ?? $asset->baja?->format('Y-m-d');
    
        // Actualizar el activo
        $asset->update($validated);
    
        // Mostrar mensaje de éxito
        $this->infoToast('Activo actualizado exitosamente');
        return redirect()->route('assets.index');
    }
    /**
     * Eliminar un recurso de la base de datos.
     */
    public function destroy(Asset $asset)
    {
        // Eliminar la imagen asociada, si existe
        if ($asset->imagen) {
            Storage::delete('public/' . $asset->imagen);
        }

        $asset->delete();

        // Mensaje de éxito
        $this->successToast('Activo eliminado exitosamente');
        return redirect()->route('assets.index');
    }

    /**
     * Subir un archivo relacionado con los activos.
     */
    public function upload(Request $request)
    {
        // Validar el archivo subido
        $validated = $request->validate([
            'file' => 'required|file|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        // Guardar el archivo
        $fileName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $fileName);

        // Mensaje de éxito
        $this->infoToast('Archivo subido correctamente');
        return back();
    }

    /**
     * Mostrar archivos relacionados.
     */
    public function showFiles()
    {
        $files = Asset::all();
        return view('show-files', compact('files'));
    }
}
