<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
{
    // SQL brut — fonctionne toujours avec SQLite
    $this->db->query('DELETE FROM soldes');
    $this->db->query('DELETE FROM conges');
    $this->db->query('DELETE FROM employes');
    $this->db->query('DELETE FROM types_conge');
    $this->db->query('DELETE FROM departements');

    $this->call('DepartementSeeder');
    $this->call('TypeCongeSeeder');
    $this->call('EmployeSeeder');
    $this->call('SoldeSeeder');
    $this->call('CongeSeeder');
    }
}
