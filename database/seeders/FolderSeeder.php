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
            ['name' => 'Formatos Vigentes', 'description' => 'Versiones actuales'],
            ['name' => 'Capacitaciones', 'description' => 'Material de entrenamiento']
        ];

        foreach ($folders as $folder) {
            Folder::create($folder);
        }
    }
}