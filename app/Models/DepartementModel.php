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
    protected $useTimestamps    = false;
    protected $allowedFields    = ['nom'];

    // getAll() — CI4 a déjà findAll() mais on garde pour clarté
    public function getAll()
    {
        return $this->findAll();
    }

    // getById() — utile pour le formulaire edit
    public function getById($id)
    {
        return $this->find($id);
    }
}