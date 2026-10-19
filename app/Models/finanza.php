<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class finanza extends Model
{
    //
    protected $table = 'finanzas';

    protected $fillable = ['monto', 'fecha', 'notas', 'id_pedido'];

    public function pedidos(){
        return $this->belongsTo(pedido::class, 'id_pedido');
    }
}
