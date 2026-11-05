<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class precio_base extends Model
{
    //
    protected $table = 'precio_bases';

    protected $fillable = [
        'nombre_prenda', 'complejidad', 'precio', 'descripcion',
        'requiere_camisa', 'requiere_pantalon', 'requiere_generales',
    ];

    protected $casts = [
        'precio'             => 'decimal:2',
        'requiere_camisa'    => 'boolean',
        'requiere_pantalon'  => 'boolean',
        'requiere_generales' => 'boolean',
    ];

    public function servicio(){
        return $this->hasMany(servicio::class, 'id_precio_bases');
    }
}
