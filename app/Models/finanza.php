<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class finanza extends Model
{
    //
    protected $table = 'finanzas';

    protected $fillable = ['monto', 'fecha', 'notas', 'id_pedido'];

    protected $casts = [
        'monto'     => 'decimal:2',
        'id_pedido' => 'integer',
    ];

    public function pedido(){
        return $this->belongsTo(pedido::class, 'id_pedido');
    }
}
