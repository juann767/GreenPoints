# 🌱 GreenPoints — Laravel (Segundo Avance)

Proyecto académico UGB — Programación Computacional IV  
Laboratorio 1, Tercer Cómputo, Segundo Avance

---

## Instalación paso a paso

```bash
# 1. Crear proyecto Laravel base
composer create-project laravel/laravel greenpoints

# 2. Copiar las carpetas del ZIP dentro del proyecto:
#    app/Http/Controllers/*  →  greenpoints/app/Http/Controllers/
#    app/Models/*            →  greenpoints/app/Models/
#    database/migrations/*   →  greenpoints/database/migrations/
#    database/seeders/*      →  greenpoints/database/seeders/
#    resources/views/*       →  greenpoints/resources/views/
#    routes/web.php          →  greenpoints/routes/web.php  (reemplazar)

# 3. Configurar .env
DB_CONNECTION=sqlite
# Eliminar las líneas DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 4. Crear archivo de base de datos (Windows PowerShell)
New-Item -Path "database\database.sqlite" -ItemType File

# 5. Generar clave
php artisan key:generate

# 6. Ejecutar migraciones + seeders
php artisan migrate --seed

# 7. Levantar servidor
php artisan serve
```

Abrir en el navegador: http://127.0.0.1:8000

**Credenciales de prueba:**
- Admin: `admin@greenpoints.com` / `password`
- Usuario: `diego@mail.com` / `password`

---

## Estructura implementada

### Modelos (app/Models/)
| Modelo | Tabla | Descripción |
|---|---|---|
| Role | roles | Roles del sistema (admin, usuario) |
| User | users | Usuarios con puntos y rol |
| AccionEcologica | acciones_ecologicas | Tipos de reciclaje con puntos |
| RegistroAccion | registros_acciones | Historial de reciclajes por usuario |
| Dispositivo | dispositivos | Puntos ecológicos físicos |
| Premio | premios | Catálogo de premios canjeables |
| Canje | canjes | Historial de canjes realizados |

### Controladores y rutas
| Módulo | Rutas implementadas |
|---|---|
| Auth | GET/POST login, register — POST logout |
| Dashboard | GET /dashboard |
| Reciclaje | GET index, GET create, POST store, DELETE destroy |
| Premios | GET index, POST canjear |
| Dispositivos | GET index, GET create, POST store, GET edit, PUT update, DELETE destroy |

### Vistas (resources/views/)
- `landing.blade.php` — Página pública de inicio
- `auth/login.blade.php` — Login
- `auth/register.blade.php` — Registro
- `layouts/app.blade.php` — Layout principal con sidebar
- `dashboard/index.blade.php` — Panel del usuario
- `reciclaje/index.blade.php` — Lista de reciclajes
- `reciclaje/create.blade.php` — Formulario de registro
- `premios/index.blade.php` — Catálogo + canje + historial
- `dispositivos/index.blade.php` — Lista de dispositivos
- `dispositivos/create.blade.php` — Registrar dispositivo
- `dispositivos/edit.blade.php` — Editar dispositivo

---

## Módulos pendientes para siguiente avance

- Panel de administración (estadísticas globales, gestión de usuarios)
- Gestión de acciones ecológicas desde el panel admin
- Subida de imágenes para premios y dispositivos
- Sistema de roles y middleware para restringir acceso admin
- Notificaciones y correos
