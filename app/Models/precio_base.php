<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class precio_base extends Model
{
    //
    protected $table = 'precio_bases';

    protected $fillable = ['nombre_prenda', 'complejidad', 'precio', 'descripcion'];
}
