<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartementModel extends Model
{
    protected $table            = 'departements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nom'];


    public function getAll()
    {
        return $this->findAll();
    }

    public function update($id)
    {
        $data = [
            'nom' => $this->nom,
        ];

        return parent::update($id, $data);
    }

    public function delete($id)
    {
        return parent::delete($id);
    }

    public function create($data)
    {
        return $this->insert($data);
    }
}
