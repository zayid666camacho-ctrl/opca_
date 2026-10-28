<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePedidoCompletoRequest;
use App\services\NuevoPedidoService;

use App\Models\pedido;
use App\repositories\PedidoRepository;
use App\services\ClientesService;
use App\services\PedidoService;
use App\services\PreciobaseService;
use App\services\TiposervicioService;
use Illuminate\Http\Request;

class PedidoController extends Controller
{

    private PedidoService $pedidoservice;
    private ClientesService $clientesservice;
    private PreciobaseService $preciobaseservice;
    private TiposervicioService $tiposervicioservice;
    private NuevoPedidoService $nuevopedidoservice;


    public function __construct(PedidoService $pedidoservice, ClientesService $clientesservice, PreciobaseService $preciobaseservice, TiposervicioService $tiposervicioservice, NuevoPedidoService $nuevopedidoservice) {
        $this->pedidoservice = $pedidoservice;
        $this->clientesservice = $clientesservice;
        $this->preciobaseservice = $preciobaseservice;
        $this->tiposervicioservice = $tiposervicioservice;
        $this->nuevopedidoservice = $nuevopedidoservice;
    }

    
    public function index()
    {
        //
        $pedidos = $this->pedidoservice->filtrar(null, null, null, null);
        return view('pedido.index', compact('pedidos'));
    }

    public function kanban()
    {
        $dias = 15;
        $pedidos_por_estado = $this->pedidoservice->listar_para_kanban($dias);
        $estados = ['recibido', 'en_proceso', 'terminado', 'entregado', 'cancelado'];

        return view('pedido.kanban', compact('pedidos_por_estado', 'estados', 'dias'));
    }

    public function cambiarEstado(int $id, Request $request)
    {
        $request->validate([
            'estado' => 'required|in:recibido,en_proceso,terminado,entregado,cancelado',
        ]);

        $resultado = $this->pedidoservice->cambiar_estado($id, $request->input('estado'));

        if (!$resultado['ok']) {
            return response()->json(['mensaje' => $resultado['mensaje']], 422);
        }

        return response()->json(['ok' => true]);
    }

    public function filtrar(Request $request){
        $pedidos = $this->pedidoservice->filtrar(
            $request->query('cliente'),
            $request->query('estado'),
            $request->query('desde'),
            $request->query('hasta')
        );
        return view('pedido._tabla', compact('pedidos'));
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $pedido = $this->pedidoservice->buscar($id);
        $cliente = $this->clientesservice->listar();
        $precio_bases = $this->preciobaseservice->listar();
        $tipo_servicios = $this->tiposervicioservice->listar();
        $historial = $this->pedidoservice->historial_cliente($pedido->idcliente, $pedido->id);

        return view('pedido.edit', compact('cliente', 'pedido', 'precio_bases', 'tipo_servicios', 'historial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
    {
        //
        $this->pedidoservice->actualizar($id, $request->all());
        return redirect()->route('pedidos.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $resultado = $this->pedidoservice->delete($id);

        if (!$resultado['ok']) {
            return redirect()->route('pedidos.index')->with('error', $resultado['mensaje']);
        }
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado.');
    }

    public function actualizar_medidas(int $id, Request $request)
    {
        $campos = [
            'ancho_espalda', 'largo_espalda', 'contorno_pecho', 'hombro', 'manga', 'puño',
            'antebrazo', 'cintura_suelta', 'largo_total', 'cintura', 'tiro', 'pierna',
            'rodilla', 'largo_pierna', 'bota',
        ];

        $reglas = [];
        foreach ($campos as $campo) {
            $reglas[$campo] = 'nullable|numeric|between:0,999.99';
        }

        $datos = $request->validate($reglas);

        $pedido = $this->pedidoservice->buscar($id);
        $this->clientesservice->actualizar($pedido->idcliente, $datos);

        return redirect()->route('pedidos.edit', $id)->with('success', 'Medidas del cliente actualizadas.');
    }

    public function nuevo(Request $request)
    {
        $fecha = $request->query('fecha');
        $precio_bases = $this->preciobaseservice->listar();
        $tipo_servicios = $this->tiposervicioservice->listar();

        return view('pedido.nuevo', compact('fecha', 'precio_bases', 'tipo_servicios'));
    }

    /**
     * Guarda el pedido completo del flujo guiado (cliente, medidas, prendas y abono).
     * La validación la hace StorePedidoCompletoRequest y el guardado atómico NuevoPedidoService.
     */
    public function guardar(StorePedidoCompletoRequest $request)
    {
        try {
            $pedido = $this->nuevopedidoservice->crear($request->validated());
        } catch (\DomainException $e) {
            // Error de negocio (ej. abono mayor al total): se vuelve al formulario con el mensaje
            return back()->withInput()->withErrors(['abono_monto' => $e->getMessage()]);
        }

        // Se vuelve al Calendario, en el mes de la fecha del pedido, para verlo ya agendado
        $fecha_pedido = \Carbon\Carbon::parse($pedido->fecha);

        return redirect()->route('calendario.index', ['mes' => $fecha_pedido->month, 'anio' => $fecha_pedido->year])
            ->with('success', 'Pedido creado correctamente.');
    }
}
