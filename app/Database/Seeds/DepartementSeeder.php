<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartementSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('departements')->insertBatch([
            ['id' => 1, 'nom' => 'Informatique'],
            ['id' => 2, 'nom' => 'Ressources Humaines'],
            ['id' => 3, 'nom' => 'Comptabilité'],
        ]);
    }
}
