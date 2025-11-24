<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Asegurar que existan las columnas necesarias
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable()->after('id');
            }
            if (! Schema::hasColumn('users', 'password')) {
                $table->string('password')->after('username');
            }
            if (! Schema::hasColumn('users', 'usertype')) {
                $table->string('usertype')->default('admin')->after('password');
            }
        });

        // 2) Hashear contraseñas que NO parecen ya hasheadas
        $users = DB::table('users')->select('id', 'password')->get();
        foreach ($users as $u) {
            $pass = (string) $u->password;
            if ($pass === '' || $pass === null) {
                continue;
            }
            // si no parece un hash bcrypt/argon (prefijos comunes), lo hasheamos
            if (! preg_match('/^\$(2y|2b|argon2|2x)/', $pass)) {
                DB::table('users')->where('id', $u->id)->update(['password' => Hash::make($pass)]);
            }
        }

        // 3) Eliminar columnas que no quieres (haz backup antes)
        Schema::table('users', function (Blueprint $table) {
            $colsToDrop = ['name','email','email_verified_at','remember_token','created_at','updated_at'];
            foreach ($colsToDrop as $col) {
                if (Schema::hasColumn('users', $col)) {
                    // DropColumn puede fallar si existen restricciones; en ese caso haz backup y revisa FK
                    $table->dropColumn($col);
                }
            }
        });
    }

    public function down(): void
    {
        // Re-crear columnas básicas (no restaura valores originales)
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            if (! Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->nullable()->after('name');
            }
            if (! Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }
            if (! Schema::hasColumn('users', 'created_at')) {
                $table->timestamps();
            }
            // eliminar username/usertype si quieres (opcional)
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'usertype')) {
                $table->dropColumn('usertype');
            }
        });
    }
};