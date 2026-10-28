<?php

namespace App\Http\Controllers;

use App\Services\GaleriaService;
use Illuminate\Http\Request;

class GaleriaController extends Controller
{
    //
     private GaleriaService $galeriaservice;
    public function __construct(GaleriaService $galeriaservice)
    {
        $this->galeriaservice = $galeriaservice;
    }
    /**
     * Muestra la lista de trabajos para administración interna (HU28).
     */
    public function index(Request $request)
    {
        $categoria = $request->input('categoria');
        $trabajos = $this->galeriaservice->listar($categoria);
        $categorias = $this->galeriaservice->categorias();
        return view('galeria.index', compact('trabajos', 'categorias', 'categoria'));
    }
    /**
     * Sube y publica un nuevo trabajo en la galería (HU27).
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:1000',
            'categoria' => 'nullable|string|max:50',
            'fecha' => 'required|date',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Máx 5MB
            'visible_publico' => 'nullable|boolean',
        ]);
        $this->galeriaservice->crear($datos, $request->file('imagen'));
        return redirect()->route('galeria.index')->with('success', 'Trabajo subido a la galería con éxito.');
    }
    /**
     * Actualiza la información o sustituye la imagen de un trabajo.
     */
    public function update(Request $request, int $id)
    {
        $datos = $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:1000',
            'categoria' => 'nullable|string|max:50',
            'fecha' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'visible_publico' => 'nullable|boolean',
        ]);
        $this->galeriaservice->actualizar($id, $datos, $request->file('imagen'));
        return redirect()->route('galeria.index')->with('success', 'Trabajo actualizado correctamente.');
    }
    /**
     * Elimina el trabajo y su archivo de imagen físico (HU28).
     */
    public function destroy(int $id)
    {
        $this->galeriaservice->delete($id);
        return redirect()->route('galeria.index')->with('success', 'Trabajo eliminado de la galería.');
    }
    /**
     * Alterna rápidamente si el trabajo es visible o no en la web pública.
     */
    public function toggle_visibilidad(int $id)
    {
        $this->galeriaservice->alternar_visibilidad($id);
        return redirect()->route('galeria.index')->with('success', 'Visibilidad actualizada.');
    }
}
