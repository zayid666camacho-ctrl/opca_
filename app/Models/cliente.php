<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    //
    protected $table = 'clientes';

    protected $fillable = [
        'nombre', 'apellido', 'correo', 'telefono', 'fecha_registro', 'ancho_espalda', 'largo_espalda', 'contorno_pecho', 'hombro', 'manga', 'puño', 'antebrazo', 'cintura_suelta', 'largo_total', 'cintura', 'tiro', 'pierna', 'rodilla', 'largo_pierna', 'bota', 'notas'
    ];

    /**
     * Las medidas corporales se guardan como decimal(5,2) en centímetros.
     */
    protected $casts = [
        'ancho_espalda'  => 'decimal:2',
        'largo_espalda'  => 'decimal:2',
        'contorno_pecho' => 'decimal:2',
        'hombro'         => 'decimal:2',
        'manga'          => 'decimal:2',
        'puño'           => 'decimal:2',
        'antebrazo'      => 'decimal:2',
        'cintura_suelta' => 'decimal:2',
        'largo_total'    => 'decimal:2',
        'cintura'        => 'decimal:2',
        'tiro'           => 'decimal:2',
        'pierna'         => 'decimal:2',
        'rodilla'        => 'decimal:2',
        'largo_pierna'   => 'decimal:2',
        'bota'           => 'decimal:2',
    ];

    public function pedido(){
        return $this->hasMany(pedido::class, 'idcliente');
    }
}
