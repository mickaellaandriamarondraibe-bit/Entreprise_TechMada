<?php
namespace App\Controllers\Employe;

use App\Controllers\BaseController;
use App\Models\SoldeModel;
use App\Models\CongeModel;
use App\Models\TypeCongeModel;  // ← manquait

class CongeController extends BaseController
{
    public function index()
    {
        $employe_id = session()->get('employe_id');
        $congeModel = new CongeModel();

        return view('employe/conge/demands', [  
            'demandes' => $congeModel->getDemandesEmploye($employe_id),
        ]);
    }

    public function create()  // ← renommé demandeForm → create (plus standard CI4)
    {
        $employe_id     = session()->get('employe_id');
        $typeCongeModel = new TypeCongeModel();
        $soldeModel     = new SoldeModel();

        // Types avec solde restant de l'employé
        $types  = $typeCongeModel->getTypesAvecSolde($employe_id);
        $soldes = $soldeModel->getSoldesAvecType($employe_id);

        return view('employe/conge/create', [  // ← corrigé chemin
            'types'  => $types,
            'soldes' => $soldes,
        ]);
    }

    public function store()
    {
        $employe_id = session()->get('employe_id');
        $congeModel = new CongeModel();
        $soldeModel = new SoldeModel();

        $type_conge_id = $this->request->getPost('type_conge_id');
        $date_debut    = $this->request->getPost('date_debut');
        $date_fin      = $this->request->getPost('date_fin');
        $motif         = $this->request->getPost('motif');

        // Calcul nb_jours
        $nb_jours = (int) date_diff(
            date_create($date_debut),
            date_create($date_fin)
        )->days + 1;

        // Vérifier solde suffisant
        if (! $soldeModel->isSoldeSuffisant($employe_id, $type_conge_id, $nb_jours)) {
            return redirect()->back()->with('error', 'Solde insuffisant pour ce type de congé.');
        }

        // Insérer la demande
        $congeModel->insert([
            'employe_id'    => $employe_id,
            'type_conge_id' => $type_conge_id,
            'date_debut'    => $date_debut,
            'date_fin'      => $date_fin,
            'nb_jours'      => $nb_jours,
            'motif'         => $motif,
            'statut'        => 'en_attente',
        ]);

        return redirect()->to(base_url('employe/conge'))
                         ->with('success', 'Demande soumise avec succès.');
    }

    public function cancel($id)
    {
        $employe_id = session()->get('employe_id');
        $congeModel = new CongeModel();

        $demande = $congeModel->find($id);

        // Vérifier que la demande appartient à l'employé connecté
        if (! $demande || $demande['employe_id'] != $employe_id) {
            return redirect()->back()->with('error', 'Demande introuvable.');
        }

        // Vérifier que c'est bien en_attente
        if ($demande['statut'] !== 'en_attente') {
            return redirect()->back()->with('error', 'Impossible d\'annuler cette demande.');
        }

        $congeModel->update($id, ['statut' => 'annulee']);

        return redirect()->to(base_url('employe/conge'))
                         ->with('success', 'Demande annulée.');
    }
}