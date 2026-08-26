<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipo_servicio extends Model
{
    //
    protected $table = 'tipo_servicios';

    protected $fillable = ['servicio', 'descripcion'];

}
