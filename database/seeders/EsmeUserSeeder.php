<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EsmeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'Esme',
            'password' => Hash::make('110502'),
            'usertype' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
