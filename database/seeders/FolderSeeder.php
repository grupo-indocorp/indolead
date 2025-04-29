<?php

namespace Database\Seeders;

use App\Models\Folder;
use Illuminate\Database\Seeder;

class FolderSeeder extends Seeder
{
    public function run()
    {
        $folders = [
            ['name' => 'Formatos Antiguos', 'description' => 'Archivos históricos'],
            ['name' => 'Capacitaciones', 'description' => 'Material de entrenamiento'],
            ['name' => 'Fija', 'description' => 'Archivos y Formatos Fija'],
            ['name' => 'Movil', 'description' => 'Archivos y Formatos Movil'],
            ['name' => 'Avanzada', 'description' => 'Archivos y Formatos Avanzada'],
            ['name' => 'CRM', 'description' => 'Archivos y Formatos CRM'],
            ['name' => 'Biblioteca', 'description' => 'Archivos y Formatos de Biblioteca'],
            
        ];

        foreach ($folders as $folder) {
            Folder::firstOrCreate(
                ['name' => $folder['name']], // Busca por este campo
                $folder // Crea si no existe
            );
        }
    }
}
