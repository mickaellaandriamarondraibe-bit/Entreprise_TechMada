<?php
namespace App\Models;
use CodeIgniter\Model;

class CongeModel extends Model
{
    protected $table         = 'conges';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'employe_id', 'type_conge_id', 'date_debut',
        'date_fin', 'nb_jours', 'motif', 'statut',
        'commentaire_rh', 'traite_par'
    ];

    // Toutes les demandes d'un employé
    public function getDemandesEmploye($employe_id)
    {
        return $this
            ->select('conges.*, types_conge.libelle')
            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
            ->where('conges.employe_id', $employe_id)
            ->orderBy('conges.created_at', 'DESC')
            ->findAll();
    }

    // 3 dernières demandes pour le dashboard
    public function getDernieresDemandes($employe_id, $limit = 3)
    {
        return $this
            ->select('conges.*, types_conge.libelle')
            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
            ->where('conges.employe_id', $employe_id)
            ->orderBy('conges.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    // Stats pour le dashboard
    public function getStats($employe_id)
    {
        return [
            'en_attente' => $this->where('employe_id', $employe_id)->where('statut', 'en_attente')->countAllResults(),
            'approuvee'  => $this->where('employe_id', $employe_id)->where('statut', 'approuvee')->countAllResults(),
            'refusee'    => $this->where('employe_id', $employe_id)->where('statut', 'refusee')->countAllResults(),
        ];
    }

    // Calculer nb_jours ouvrables (sans weekends)
    public function calculerJoursOuvrables($date_debut, $date_fin)
    {
        $debut  = new \DateTime($date_debut);
        $fin    = new \DateTime($date_fin);
        $jours  = 0;

        while ($debut <= $fin) {
            $jour = (int) $debut->format('N'); // 1=lundi ... 7=dimanche
            if ($jour < 6) {  // 6=samedi, 7=dimanche
                $jours++;
            }
            $debut->modify('+1 day');
        }

        return $jours;
    }

    // Vérifier si date_debut tombe un weekend
    public function isWeekend($date)
    {
        $jour = (int) (new \DateTime($date))->format('N');
        return $jour >= 6; // 6=samedi, 7=dimanche
    }

    // Toutes les demandes en attente — pour le RH
    public function getDemandesEnAttente()
    {
        return $this
            ->select('conges.*, types_conge.libelle, employes.nom, employes.prenom')
            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
            ->join('employes',    'employes.id = conges.employe_id')
            ->where('conges.statut', 'en_attente')
            ->orderBy('conges.created_at', 'ASC')
            ->findAll();
    }

    public function insertDemande($data)
    {
        return $this->insert($data);
    }

}