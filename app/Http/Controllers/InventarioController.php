<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InventarioService;

class InventarioController extends Controller
{
    //
    private InventarioService $inventarioservice;
    public function __construct(InventarioService $inventarioservice)
    {
        $this->inventarioservice = $inventarioservice;
    }
    /**
     * Muestra la lista de materiales con filtros y alerta de stock bajo.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $categoria = $request->input('categoria');
        $materiales = $this->inventarioservice->listar($buscar, $categoria);
        $alertas = $this->inventarioservice->obtener_alertas();
        $categorias = $this->inventarioservice->categorias();
        return view('inventario.index', compact('materiales', 'alertas', 'categorias', 'buscar', 'categoria'));
    }
    /**
     * Registra un nuevo material en el inventario.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'categoria' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'unidad' => 'required|string|max:30',
            'precio_unitario' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
        ]);
        $this->inventarioservice->crear($datos);
        return redirect()->route('inventario.index')->with('success', 'Material registrado correctamente.');
    }
    /**
     * Actualiza los datos o el stock de un material existente.
     */
    public function update(Request $request, int $id)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'categoria' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'unidad' => 'required|string|max:30',
            'precio_unitario' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
        ]);
        $this->inventarioservice->actualizar($id, $datos);
        return redirect()->route('inventario.index')->with('success', 'Material actualizado correctamente.');
    }
    /**
     * Elimina un material del inventario.
     */
    public function destroy(int $id)
    {
        $this->inventarioservice->delete($id);
        return redirect()->route('inventario.index')->with('success', 'Material eliminado correctamente.');
    }
}
