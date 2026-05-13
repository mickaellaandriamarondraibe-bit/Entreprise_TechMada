<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class EmployeSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('employes')->insertBatch([
            [
                'nom'            => 'Admin',
                'prenom'         => 'Principal',
                'email'          => 'admin@test.com',
                'password'       => password_hash('1234', PASSWORD_DEFAULT),
                'role'           => 'admin',
                'departement_id' => 1,
                'actif'          => 1,
            ],
            [
                'nom'            => 'RH',
                'prenom'         => 'Responsable',
                'email'          => 'rh@test.com',
                'password'       => password_hash('1234', PASSWORD_DEFAULT),
                'role'           => 'rh',
                'departement_id' => 2,
                'actif'          => 1,
            ],
            [
                'nom'            => 'Rakoto',
                'prenom'         => 'Jean',
                'email'          => 'employe@test.com',
                'password'       => password_hash('1234', PASSWORD_DEFAULT),
                'role'           => 'employe',
                'departement_id' => 1,
                'actif'          => 1,
            ],
        ]);
    }
}