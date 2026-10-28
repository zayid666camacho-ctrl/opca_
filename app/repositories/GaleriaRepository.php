<?php

namespace App\Repositories;

use App\Models\Galeria;

class GaleriaRepository
{
    /**
     * Lista los trabajos registrados.
     * Si $solo_visibles es true, filtra solo los aprobados para la galería pública.
     * Ordena estrictamente de más reciente a más antiguo (Regla de negocio 11 y HU29).
     */
    public function listar(?string $categoria = null, bool $solo_visibles = false)
    {
        $consulta = Galeria::query();

        if ($solo_visibles) {
            $consulta->where('visible_publico', true);
        }

        if ($categoria) {
            $consulta->where('categoria', $categoria);
        }

        return $consulta->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function buscar(int $id)
    {
        return Galeria::findOrFail($id);
    }

    public function crear(array $datos)
    {
        return Galeria::create($datos);
    }

    public function actualizar(int $id, array $datos)
    {
        $trabajo = $this->buscar($id);
        $trabajo->update($datos);
        return $trabajo;
    }

    public function delete(int $id)
    {
        Galeria::destroy($id);
    }

    /**
     * Alterna la visibilidad pública (publicar u ocultar del sitio público).
     */
    public function alternar_visibilidad(int $id)
    {
        $trabajo = $this->buscar($id);
        $trabajo->visible_publico = !$trabajo->visible_publico;
        $trabajo->save();
        return $trabajo;
    }

    /**
     * Retorna las categorías únicas existentes de prendas para los filtros.
     */
    public function categorias()
    {
        return Galeria::distinct()
            ->whereNotNull('categoria')
            ->where('categoria', '!=', '')
            ->orderBy('categoria', 'asc')
            ->pluck('categoria');
    }
}