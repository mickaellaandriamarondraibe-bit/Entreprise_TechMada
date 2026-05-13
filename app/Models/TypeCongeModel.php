<?php
<<<<<<< HEAD
namespace App\Models;
=======

namespace App\Models;

>>>>>>> ad0622f9a1f2abaa434908eabe9528ba9b0c3c0e
use CodeIgniter\Model;

class TypeCongeModel extends Model
{
<<<<<<< HEAD
    protected $table         = 'types_conge';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['libelle', 'jours_annuels', 'deductible'];

    // Tous les types avec solde restant de l'employé
    public function getTypesAvecSolde($employe_id)
    {
        return $this->db->table('types_conge')
            ->select('types_conge.*, 
                      COALESCE(soldes.jours_attribues, 0) - COALESCE(soldes.jours_pris, 0) AS solde')
            ->join('soldes', 
                   'soldes.type_conge_id = types_conge.id 
                    AND soldes.employe_id = ' . $employe_id . ' 
                    AND soldes.annee = ' . date('Y'), 'left')
            ->get()
            ->getResultArray();
    }
}
=======
    protected $table            = 'typeconges';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
    'libelle',
    'jours_annuels',
    'deductible',
];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
>>>>>>> ad0622f9a1f2abaa434908eabe9528ba9b0c3c0e
