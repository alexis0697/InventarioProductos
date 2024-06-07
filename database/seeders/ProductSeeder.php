<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create([
            'nombre' => 'Producto 1',
            'descripcion' => 'Descripción del Producto 1',
            'precio' => 10.50,
            'cantidad' => 100,
        ]);

        Producto::create([
            'nombre' => 'Producto 2',
            'descripcion' => 'Descripción del Producto 2',
            'precio' => 20.00,
            'cantidad' => 200,
        ]);

        Producto::create([
            'nombre' => 'Producto 3',
            'descripcion' => 'Descripción del Producto 3',
            'precio' => 30.25,
            'cantidad' => 150,
        ]);

        Producto::create([
            'nombre' => 'Producto 4',
            'descripcion' => 'Descripción del Producto 4',
            'precio' => 40.75,
            'cantidad' => 250,
        ]);

        Producto::create([
            'nombre' => 'Producto 5',
            'descripcion' => 'Descripción del Producto 5',
            'precio' => 50.00,
            'cantidad' => 300,
        ]);
    }
}
