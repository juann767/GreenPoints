<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nombre' => 'admin',   'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'usuario', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('users')->insert([
            ['role_id' => 1, 'nombre' => 'Administrador', 'email' => 'admin@greenpoints.com', 'password' => Hash::make('password'), 'puntos' => 0,   'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'nombre' => 'Diego López',   'email' => 'diego@mail.com',         'password' => Hash::make('password'), 'puntos' => 307, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('acciones_ecologicas')->insert([
            ['nombre' => 'Reciclaje de papel y cartón', 'descripcion' => 'Depositar papel o cartón en el contenedor.', 'puntos_otorgados' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Reciclaje de vidrio',         'descripcion' => 'Depositar botellas y envases de vidrio.',   'puntos_otorgados' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Reciclaje de metal',          'descripcion' => 'Depositar latas y objetos metálicos.',      'puntos_otorgados' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Reciclaje de plástico',       'descripcion' => 'Depositar envases y bolsas plásticas.',    'puntos_otorgados' => 25, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Dispositivos con coordenadas de San Miguel Centro, El Salvador
        DB::table('dispositivos')->insert([
            [
                'nombre'      => 'Punto Verde — Parque David J. Guzmán',
                'ubicacion'   => 'Parque Central, San Miguel Centro',
                'descripcion' => 'Acepta papel, vidrio, plástico.',
                'estado'      => 'activo',
                'latitud'     => 13.4833,
                'longitud'    => -88.1833,
                'created_at'  => now(), 'updated_at' => now(),
            ],
            [
                'nombre'      => 'EcoBox — Mercado Central San Miguel',
                'ubicacion'   => 'Av. Roosevelt Sur, San Miguel',
                'descripcion' => 'Acepta plástico, aluminio, cartón.',
                'estado'      => 'activo',
                'latitud'     => 13.4810,
                'longitud'    => -88.1790,
                'created_at'  => now(), 'updated_at' => now(),
            ],
            [
                'nombre'      => 'EcoStation — Alcaldía Municipal San Miguel',
                'ubicacion'   => '4a Calle Oriente, San Miguel Centro',
                'descripcion' => 'Acepta todo tipo de material reciclable.',
                'estado'      => 'mantenimiento',
                'latitud'     => 13.4822,
                'longitud'    => -88.1815,
                'created_at'  => now(), 'updated_at' => now(),
            ],
            [
                'nombre'      => 'Punto Verde — Catedral de San Miguel',
                'ubicacion'   => 'Frente a la Catedral, San Miguel Centro',
                'descripcion' => 'Acepta vidrio, metal, papel.',
                'estado'      => 'activo',
                'latitud'     => 13.4840,
                'longitud'    => -88.1820,
                'created_at'  => now(), 'updated_at' => now(),
            ],
        ]);

        DB::table('premios')->insert([
            ['nombre' => 'Kit de siembra',       'descripcion' => 'Kit completo para cultivar plantas en casa.',     'puntos_requeridos' => 200, 'stock' => 10, 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Bolsa ecológica',      'descripcion' => 'Bolsa reutilizable de tela resistente.',          'puntos_requeridos' => 150, 'stock' => 20, 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Botella reutilizable', 'descripcion' => 'Botella de acero inoxidable 500ml.',              'puntos_requeridos' => 350, 'stock' => 8,  'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Libro ambiental',      'descripcion' => 'Libro sobre sostenibilidad y medio ambiente.',    'puntos_requeridos' => 160, 'stock' => 15, 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Certificado eco',      'descripcion' => 'Certificado digital de participación ecológica.', 'puntos_requeridos' => 100, 'stock' => 99, 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
