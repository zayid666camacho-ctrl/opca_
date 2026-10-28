<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class galeria extends Model
{
    //
    protected $table = 'galerias';
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'categoria',
        'fecha',
        'realizado_por',
        'visible_publico',
    ];
    protected $casts = [
        'fecha' => 'datetime',
        'visible_publico' => 'boolean',
    ];
    /**
     * Retorna la URL pública de la foto guardada en storage.
     */
    public function url_imagen(): string
    {
        if ($this->imagen && Storage::disk('public')->exists($this->imagen)) {
            return asset('storage/' . $this->imagen);
        }
        // Imagen de muestra por si el archivo físico no existe
        return 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=600&auto=format&fit=crop&q=80';
    }
}
