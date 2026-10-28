<?php

namespace App\Services;

use App\Repositories\GaleriaRepository;
use Illuminate\Support\Facades\Storage;

class GaleriaService
{
    private GaleriaRepository $galeriarepository;

    public function __construct(GaleriaRepository $galeriarepository)
    {
        $this->galeriarepository = $galeriarepository;
    }

    public function listar(?string $categoria = null, bool $solo_visibles = false)
    {
        return $this->galeriarepository->listar($categoria, $solo_visibles);
    }

    public function buscar(int $id)
    {
        return $this->galeriarepository->buscar($id);
    }

    /**
     * Guarda la imagen física en storage/app/public/galeria y crea el registro en BD (HU27).
     */
    public function crear(array $datos, $archivo_imagen)
    {
        if ($archivo_imagen) {
            // Guarda la foto en storage/app/public/galeria
            $ruta = $archivo_imagen->store('galeria', 'public');
            $datos['imagen'] = $ruta;
        }

        $datos['realizado_por'] = $datos['realizado_por'] ?? 'Creaciones Nayja';
        $datos['visible_publico'] = isset($datos['visible_publico']) ? (bool) $datos['visible_publico'] : true;

        return $this->galeriarepository->crear($datos);
    }

    /**
     * Actualiza los datos y reemplaza la foto física si se sube una nueva.
     */
    public function actualizar(int $id, array $datos, $archivo_imagen = null){
        $trabajo = $this->galeriarepository->buscar($id);

        if ($archivo_imagen) {
            // Borra la imagen anterior del disco si existe
            if ($trabajo->imagen && Storage::disk('public')->exists($trabajo->imagen)) {
                Storage::disk('public')->delete($trabajo->imagen);
            }
            // Guarda la nueva foto
            $datos['imagen'] = $archivo_imagen->store('galeria', 'public');
        }

        $datos['visible_publico'] = isset($datos['visible_publico']) ? (bool) $datos['visible_publico'] : false;

        return $this->galeriarepository->actualizar($id, $datos);
    }

    /**
     * Elimina el registro y el archivo físico del disco duro (HU28).
     */
    public function delete(int $id){
        $trabajo = $this->galeriarepository->buscar($id);

        // Elimina el archivo de imagen física para no desperdiciar espacio
        if ($trabajo->imagen && Storage::disk('public')->exists($trabajo->imagen)) {
            Storage::disk('public')->delete($trabajo->imagen);
        }

        $this->galeriarepository->delete($id);
    }

    public function alternar_visibilidad(int $id){
        return $this->galeriarepository->alternar_visibilidad($id);
    }

    public function categorias(){
        return $this->galeriarepository->categorias();
    }
}