<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    //
    protected $table = 'pedidos';

    protected $fillable = ['fecha', 'fecha_entrega', 'estado', 'descripcion', 'precio', 'saldo_pendiente', 'idcliente'];

    /**
     * 'fecha' y 'fecha_entrega' se dejan como texto Y-m-d a propósito:
     * así se usan directo en los <input type="date"> y en el Calendario.
     */
    protected $casts = [
        'precio'          => 'decimal:2',
        'saldo_pendiente' => 'decimal:2',
        'idcliente'       => 'integer',
    ];

    public function cliente(){
        return $this->belongsTo(cliente::class,'idcliente');
    }

    public function servicios(){
        return $this->hasMany(servicio::class, 'id_pedido');
    }

    public function finanzas(){
        return $this->hasMany(finanza::class, 'id_pedido');
    }
}
