<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FixEsmeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eliminar el usuario existente si existe
        DB::table('users')->where('username', 'Esme')->delete();
        
        // Crear el usuario correctamente
        DB::table('users')->insert([
            'username' => 'Esme',
            'password' => Hash::make('110502'),
            'usertype' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo "Usuario Esme creado correctamente con contraseña: 110502\n";
    }
}
