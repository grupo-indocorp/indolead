<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /** Tablas unitarias
         * Se usa para user, cliente, equipo:
         * SedeSeeder
         * 
         * Datos Adicionales de Movistar:
         * EstadowickSeeder, EstadoditoSeeder, ClientetipoSeeder, AgenciaSeeder
         * 
         * Para el uso de la Agenda:
         * NotificaciontipoSeeder
         * 
         * Se crean los roles y permisos
         * RoleSeeder
         * 
         * Etiqueta
         */
        $this->call(SedeSeeder::class);
        $this->call(EstadowickSeeder::class);
        $this->call(EstadoditoSeeder::class);
        $this->call(ClientetipoSeeder::class);
        $this->call(AgenciaSeeder::class);
        $this->call(NotificaciontipoSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(EtiquetaSeeder::class);

        /** Tablas dependientes
         * Creamos usuario:
         * UserSeeder
         */
        $this->call(UserSeeder::class);
    }
}
