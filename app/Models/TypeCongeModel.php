<?php
namespace App\Models;
use CodeIgniter\Model;

class TypeCongeModel extends Model
{
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