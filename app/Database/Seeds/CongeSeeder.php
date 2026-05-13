<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CongeSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('conges')->insertBatch([
            [
                'employe_id' => 3,
                'type_conge_id' => 1,
                'date_debut' => '2026-06-10',
                'date_fin' => '2026-06-14',
                'nb_jours' => 5,
                'motif' => 'Vacances',
                'statut' => 'en_attente',
                'commentaire_rh' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'traite_par' => null,
            ],
        ]);
    }
}