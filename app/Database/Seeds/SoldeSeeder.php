<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SoldeSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('soldes')->insertBatch([
            ['employe_id' => 3, 'type_conge_id' => 1, 'annee' => 2026, 'jours_attribues' => 30, 'jours_pris' => 0],
            ['employe_id' => 3, 'type_conge_id' => 2, 'annee' => 2026, 'jours_attribues' => 15, 'jours_pris' => 0],
            ['employe_id' => 3, 'type_conge_id' => 3, 'annee' => 2026, 'jours_attribues' => 5, 'jours_pris' => 0],
        ]);
    }
}
