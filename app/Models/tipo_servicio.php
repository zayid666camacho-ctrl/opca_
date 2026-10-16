<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;

class tipo_servicio extends Model
{
    //
    protected $table = 'tipo_servicios';

    protected $fillable = ['servicio', 'descripcion'];

    public function servicio(){
        return $this->hasMany(servicio::class);
    }

    /*---------------------------------------------------------------*/

    protected function nombre(): Attribute
    {
        $etiquetas = [
            'arreglo'    => 'Arreglo',
            'confeccion' => 'Confección',
            'diseno'     => 'Diseño',
        ];

        return Attribute::make(
            get: fn () => $etiquetas[$this->servicio] ?? ucfirst($this->servicio),
        );
    }

}
