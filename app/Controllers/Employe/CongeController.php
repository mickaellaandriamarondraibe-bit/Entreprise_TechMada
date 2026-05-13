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
        $employe_id    = session()->get('employe_id');
        $congeModel    = new CongeModel();
        $soldeModel    = new SoldeModel();

        $type_conge_id = $this->request->getPost('type_conge_id');
        $date_debut    = $this->request->getPost('date_debut');
        $date_fin      = $this->request->getPost('date_fin');
        $motif         = $this->request->getPost('motif');

        // Vérifier si date_debut est un weekend
        if ($congeModel->isWeekend($date_debut)) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'La date de début ne peut pas être un samedi ou dimanche.');
        }

        // Vérifier si date_fin est un weekend
        if ($congeModel->isWeekend($date_fin)) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'La date de fin ne peut pas être un samedi ou dimanche.');
        }

        // Vérifier que date_fin >= date_debut
        if ($date_fin < $date_debut) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'La date de fin doit être après la date de début.');
        }

        // Calcul jours ouvrables seulement
        $nb_jours = $congeModel->calculerJoursOuvrables($date_debut, $date_fin);

        if ($nb_jours === 0) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Aucun jour ouvrable dans cette période.');
        }

        // Vérifier solde suffisant
        if (! $soldeModel->isSoldeSuffisant($employe_id, $type_conge_id, $nb_jours)) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Solde insuffisant — il vous reste moins de ' . $nb_jours . ' jours.');
        }

        $congeModel->insert([
            'employe_id'    => $employe_id,
            'type_conge_id' => $type_conge_id,
            'date_debut'    => $date_debut,
            'date_fin'      => $date_fin,
            'nb_jours'      => $nb_jours,
            'motif'         => $motif,
            'statut'        => 'en_attente',
        ]);

        return redirect()->to(base_url('employe/conges'))
                        ->with('success', 'Demande soumise — ' . $nb_jours . ' jours ouvrables.');
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

        return redirect()->to(base_url('employe/conges'))
                         ->with('success', 'Demande annulée.');
    }
}