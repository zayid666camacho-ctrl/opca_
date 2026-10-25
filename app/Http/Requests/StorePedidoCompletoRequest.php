<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePedidoCompletoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'fecha'         => 'required|date',
            'fecha_entrega' => 'required|date|after_or_equal:fecha',
            'descripcion'   => 'nullable|string|max:255',

            'cliente_modo' => 'required|in:nuevo,existente',
            'idcliente'    => 'required_if:cliente_modo,existente|nullable|exists:clientes,id',

            'cliente.nombre'   => 'required_if:cliente_modo,nuevo|nullable|string|max:255',
            'cliente.apellido' => 'required_if:cliente_modo,nuevo|nullable|string|max:255',
            'cliente.correo'   => 'required_if:cliente_modo,nuevo|nullable|email|max:255',
            'cliente.telefono' => 'required_if:cliente_modo,nuevo|nullable|string|max:20',

            'prendas'                     => 'required|array|min:1',
            'prendas.*.id_precio_bases'   => 'required|exists:precio_bases,id',
            'prendas.*.id_tipo_servicios' => 'required|exists:tipo_servicios,id',
            'prendas.*.descripcion'       => 'nullable|string|max:255',

            'medidas'   => 'nullable|array',
            'medidas.*' => 'nullable|numeric|between:0,999.99',

            'abono_activo' => 'nullable|boolean',
            'abono_monto'  => 'required_if:abono_activo,1|nullable|numeric|gt:0',
            'abono_fecha'  => 'required_if:abono_activo,1|nullable|date',
            'abono_notas'  => 'nullable|string|max:255',
        ];
    }
}
