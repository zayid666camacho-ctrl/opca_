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
}
