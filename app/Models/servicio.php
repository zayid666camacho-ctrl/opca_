<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class servicio extends Model
{
    //
    protected $table = 'servicios';

    protected $fillable = ['descripcion', 'precio', 'id_pedido', 'id_precio_bases', 'id_tipo_servicios'];

    public function pedido(){
        return $this->belongsTo(pedido::class, 'id_pedido');
    }

    public function precio_base(){
        return $this->belongsTo(precio_base::class, 'id_precio_bases');
    }

    public function tipo_servicio(){
        return $this->belongsTo(tipo_servicio::class, 'id_tipo_servicios');
    }
}
