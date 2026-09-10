<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',

            // Medidas embebidas — todas opcionales según el ERD (decimal 5,2) para que no sean requeridas
            'ancho_espalda' => 'nullable|numeric|min:0|max:999.99',
            'largo_espalda' => 'nullable|numeric|min:0|max:999.99',
            'contorno_pecho' => 'nullable|numeric|min:0|max:999.99',
            'hombro' => 'nullable|numeric|min:0|max:999.99',
            'manga' => 'nullable|numeric|min:0|max:999.99',
            'puño' => 'nullable|numeric|min:0|max:999.99',
            'antebrazo' => 'nullable|numeric|min:0|max:999.99',
            'cintura_suelta' => 'nullable|numeric|min:0|max:999.99',
            'largo_total' => 'nullable|numeric|min:0|max:999.99',
            'cintura' => 'nullable|numeric|min:0|max:999.99',
            'tiro' => 'nullable|numeric|min:0|max:999.99',
            'pierna' => 'nullable|numeric|min:0|max:999.99',
            'rodilla' => 'nullable|numeric|min:0|max:999.99',
            'largo_pierna' => 'nullable|numeric|min:0|max:999.99',
            'bota' => 'nullable|numeric|min:0|max:999.99',

            'notas' => 'nullable|string|min:0|max:1000',

        ];
    }
}
