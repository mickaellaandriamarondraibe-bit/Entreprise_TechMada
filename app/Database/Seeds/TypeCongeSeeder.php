<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TypeCongeSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('types_conge')->insertBatch([
            ['id' => 1, 'libelle' => 'Congé annuel', 'jours_annuels' => 30, 'deductible' => 1],
            ['id' => 2, 'libelle' => 'Congé maladie', 'jours_annuels' => 15, 'deductible' => 0],
            ['id' => 3, 'libelle' => 'Congé exceptionnel', 'jours_annuels' => 5, 'deductible' => 1],
        ]);
    }
}