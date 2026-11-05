# OPCA — Creaciones Nayja

**OPCA (*Optimizar la gestión de Pedidos, Confecciones y Arreglos*)** es una solución de software web desarrollada en **Laravel** para optimizar la gestión operativa, financiera y comercial del taller de modistería **Creaciones Nayja**, ubicado en el área de influencia del **Centro Agroempresarial y Turístico de los Andes (SENA — Tecnología en Análisis y Desarrollo de Software, ADSO)**.

---

## Objetivo del Proyecto

Resolver la problemática de registro manual en cuadernos físicos, pérdida de medidas corporales de clientes, dificultad en el seguimiento de fechas de entrega, control de abonos/saldos pendientes y visibilidad comercial de los trabajos realizados por el taller.

---

## Arquitectura en Capas (Competencia AP5)

El sistema implementa una arquitectura desacoplada en capas siguiendo las convenciones de Laravel y el estándar PSR-12:

1. **Presentación (Vistas Blade):** Plantillas reutilizables (`resources/views/layouts/module.blade.php`, `resources/views/layouts/publico.blade.php`), componentes (`<x-card>`, `<x-alert>`) y parciales libres de consultas a base de datos.
2. **Controladores (`app/Http/Controllers/`):** Controladores livianos que reciben la petición HTTP, validan los datos de entrada (`FormRequest` o `$request->validate()`) y delegan en la capa de Servicios.
3. **Servicios (`app/services/`):** Concentran la lógica de negocio, cálculos de precios congelados, saldos pendientes, alertas de stock y transacciones atómicas (`NuevoPedidoService`, `PedidoService`, `finanzaService`, `inventarioService`, `GaleriaService`, `ClientesService`, `servicioService`, `PreciobaseService`, `TiposervicioService`).
4. **Repositorios e Interfaces (`app/repositories/` y `app/repositories/Contracts/`):** Contratos (`*RepositoryInterface`) y sus implementaciones con Eloquent ORM, enlazados en `App\Providers\AppServiceProvider`.
5. **Modelos y Base de Datos (`app/Models/`, `database/migrations/`, `database/seeders/`):** Modelos Eloquent con relaciones (`belongsTo`, `hasMany`), atributos `$fillable` y `$casts`, respaldados por migraciones y seeders coherentes.

---

## Módulos Principales

### 1. Sitio Web Público (Sin sesión)
- **Inicio (`/`):** Presentación del taller, servicios ofrecidos, trabajos destacados y datos de contacto editables desde el panel.
- **Galería de Trabajos (`/trabajos`):** Catálogo filtrable por categoría con referencia única (`Ref. #ID`), visor de imagen y botón de consulta directa por WhatsApp con enlace al trabajo.
- **Catálogo de Tarifas (`/tarifas`):** Lista de precios base referenciales por prenda y complejidad con consulta directa por WhatsApp.
- **Consulta de Estado de Pedido (`/mi-pedido`):** Permite a cualquier cliente consultar el avance de sus pedidos (`Recibido`, `En proceso`, `Terminado`, `Entregado`) ingresando su correo electrónico.

### 2. Panel Administrativo (Protegido con Autenticación y Permisos)
- **Calendario Operativo (`/calendario`):** Vista mensual interactiva con indicadores de pedidos recibidos, marcas de agua de fechas de entrega (`↳ Entrega`) y resumen rápido por pedido.
- **Flujo Guiado de Nuevo Pedido (`/pedidos/nuevo`):** Registro atómico en 4 pasos (Cliente nuevo o existente → Prendas y servicios con precio congelado → Medidas corporales según prenda → Abono inicial opcional).
- **Tablero Kanban (`/pedidos/kanban`) y Listado de Pedidos (`/pedidos`):** Gestión visual del ciclo de vida del pedido (`recibido`, `en_proceso`, `terminado`, `entregado`, `cancelado`) con reglas de negocio de transición y filtros avanzados.
- **Clientes y Medidas (`/clientes`):** Directorio de clientes con expediente de 15 medidas corporales (camisa, pantalón y generales) e historial de pedidos.
- **Catálogos de Precios Base (`/precio_bases`) y Tipos de Servicio (`/tipo_servicio`):** Administración de tarifas y modalidades (*Confección*, *Arreglo*, *Diseño*).
- **Finanzas y Reportes (`/finanzas`):** Control de abonos, cálculo automático de saldos pendientes, resumen mensual por año y **exportación de reporte contable en Excel (`.xlsx`)**.
- **Inventario de Insumos (`/inventario`):** Control de existencias de telas, hilos, cremalleras y botones con **alerta automática de stock mínimo**.
- **Galería Interna (`/galeria`) y Perfil del Taller (`/perfil-taller`):** Publicación/ocultamiento de fotografías de trabajos y actualización de datos de contacto públicos del taller.
- **Seguridad (`/login`, `/olvide-contrasena`, Roles y Permisos):** Autenticación, recuperación de contraseña por correo, protección CSRF, contraseñas cifradas con Bcrypt y control de acceso por roles/permisos (`spatie/laravel-permission`).

---

## Requisitos del Sistema

- **PHP** >= 8.3 (con extensiones `pdo_sqlite`, `mbstring`, `gd`, `zip`, `xml`)
- **Composer** >= 2.x
- **SQLite** (configurado por defecto para facilitar el despliegue local sin requerir servidor externo) o MySQL/MariaDB.

---

## Instrucciones de Instalación y Ejecución

Sigue estos pasos en la terminal para instalar y ejecutar el proyecto desde cero:

### 1. Clonar el repositorio
```bash
git clone <URL_DEL_REPOSITORIO>
cd opca_
```

### 2. Instalar dependencias de PHP con Composer
```bash
composer install
```

### 3. Configurar el archivo de entorno (`.env`) y la base de datos SQLite
En **Windows (PowerShell)**:
```powershell
Copy-Item .env.example .env
if (!(Test-Path database/database.sqlite)) { New-Item -ItemType File -Path database/database.sqlite }
```
En **Linux / macOS / Git Bash**:
```bash
cp .env.example .env
touch database/database.sqlite
```

### 4. Generar la clave de cifrado de la aplicación
```bash
php artisan key:generate
```

### 5. Ejecutar las migraciones y los Seeders de datos de prueba
```bash
php artisan migrate:fresh --seed
```
> Este comando crea todas las tablas y carga automáticamente el rol administrador, la cuenta administradora, los tipos de servicio, el catálogo de precios base, materiales de inventario (incluyendo alertas de stock bajo), clientes con medidas corporales, pedidos en distintos estados y abonos financieros.

### 6. Crear el enlace simbólico del almacenamiento público (para imágenes de la galería)
```bash
php artisan storage:link
```

### 7. Iniciar el servidor de desarrollo
```bash
php artisan serve
```
Abre en el navegador: **http://127.0.0.1:8000**

---

## Credenciales de Acceso por Defecto

Para ingresar al panel administrativo en **http://127.0.0.1:8000/login**:

- **Correo electrónico:** `admin@admin.com`
- **Contraseña:** `12345678`

*(Estos valores iniciales se definen en `config/seguridad.php` o mediante las variables `SEGURIDAD_ADMIN_EMAIL` y `SEGURIDAD_ADMIN_PASSWORD` en el archivo `.env`. Al modificarlos, ejecuta `php artisan db:seed --class=SeguridadSeeder` para actualizar la cuenta principal).*

---

## Ejecución de Pruebas Automatizadas (PHPUnit)

El proyecto incluye pruebas automatizadas (`Feature` y `Unit`) que se ejecutan sobre una base de datos SQLite en memoria (`:memory:`), sin afectar los datos locales:

```bash
php artisan test
```

---

## Autor

- **Desarrollador:** Jaiver Zayid Caicedo Camacho
- **Programa:** Tecnología en Análisis y Desarrollo de Software (ADSO)
- **Centro de Formación:** Centro Agroempresarial y Turístico de los Andes — SENA
- **Proyecto:** OPCA — Creaciones Nayja (2026)
