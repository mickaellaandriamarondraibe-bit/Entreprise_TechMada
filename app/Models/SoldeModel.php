<?php
namespace App\Models;
use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table         = 'soldes';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'employe_id', 'type_conge_id', 'annee',
        'jours_attribues', 'jours_pris'
    ];

    // Récupérer les soldes avec le libellé du type de congé
    public function getSoldesAvecType($employe_id)
    {
        return $this
            ->select('soldes.*, types_conge.libelle')
            ->join('types_conge', 'types_conge.id = soldes.type_conge_id')
            ->where('soldes.employe_id', $employe_id)
            ->where('soldes.annee', date('Y'))
            ->findAll();
    }

    // Vérifier si solde suffisant avant approbation
    public function isSoldeSuffisant($employe_id, $type_conge_id, $nb_jours)
    {
        $solde = $this
            ->where('employe_id', $employe_id)
            ->where('type_conge_id', $type_conge_id)
            ->where('annee', date('Y'))
            ->first();

        if (! $solde) return false;

        $restant = $solde['jours_attribues'] - $solde['jours_pris'];
        return $restant >= $nb_jours;
    }

    // Déduire les jours à l'approbation
    public function deduireJours($employe_id, $type_conge_id, $nb_jours)
    {
        $solde = $this
            ->where('employe_id', $employe_id)
            ->where('type_conge_id', $type_conge_id)
            ->where('annee', date('Y'))
            ->first();

        return $this->update($solde['id'], [
            'jours_pris' => $solde['jours_pris'] + $nb_jours
        ]);
    }

    // Recréditer les jours si refus après approbation
    public function recrediterJours($employe_id, $type_conge_id, $nb_jours)
    {
        $solde = $this
            ->where('employe_id', $employe_id)
            ->where('type_conge_id', $type_conge_id)
            ->where('annee', date('Y'))
            ->first();

        return $this->update($solde['id'], [
            'jours_pris' => $solde['jours_pris'] - $nb_jours
        ]);
    }
}