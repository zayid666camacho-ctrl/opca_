<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    //
    protected $table = 'pedidos';

    protected $fillable = ['fecha', 'fecha_entrega', 'estado', 'descripcion', 'precio', 'saldo_pendiente', 'idcliente'];

    public function cliente(){
        return $this->belongsTo(cliente::class,'idcliente');
    }
}
