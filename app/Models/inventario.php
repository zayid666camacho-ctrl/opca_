<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario extends Model
{
    protected $table = 'inventarios';

    protected $fillable = [
        'nombre',
        'categoria',
        'stock',
        'unidad',
        'precio_unitario',
        'stock_minimo',
    ];

    protected $casts = [
        'stock' => 'integer',
        'stock_minimo' => 'integer',
        'precio_unitario' => 'decimal:2',
    ];

    /**
     * Determina si el material tiene stock igual o inferior al mínimo configurado.
     */
    public function tiene_stock_bajo(): bool
    {
        return (int) $this->stock <= (int) $this->stock_minimo;
    }
}

