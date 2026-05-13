<?php

namespace App\Controllers\RH;

use App\Models\CongeModel;
use App\Models\SoldeModel;
use App\Controllers\BaseController;

class RhController extends BaseController
{
    public function demandes()
{
    $congeModel = new CongeModel();

    $statut = $this->request->getGet('statut');

    $builder = $congeModel
        ->select('conges.*, employes.nom, employes.prenom, departements.nom AS departement_nom, types_conge.libelle AS type_conge')
        ->join('employes', 'employes.id = conges.employe_id')
        ->join('departements', 'departements.id = employes.departement_id', 'left')
        ->join('types_conge', 'types_conge.id = conges.type_conge_id');

    if (! empty($statut)) {
        $builder->where('conges.statut', $statut);
    }

    $data['demandes'] = $builder
        ->orderBy('conges.created_at', 'DESC')
        ->findAll();

    $data['statutActif'] = $statut ?? 'tous';

    return view('rh/demandes', $data);
}

        public function approuver($id)
    {
            $congeModel = new CongeModel();
            $soldeModel = new SoldeModel();

            $demande = $congeModel->find($id);

            if (! $demande) {
                return redirect()->to('/rh/demandes')
                    ->with('error', 'Demande introuvable.');
            }

            if ($demande['statut'] !== 'en_attente') {
                return redirect()->to('/rh/demandes')
                    ->with('error', 'Cette demande a déjà été traitée.');
            }

            $annee = date('Y', strtotime($demande['date_debut']));

            $solde = $soldeModel
                ->where('employe_id', $demande['employe_id'])
                ->where('type_conge_id', $demande['type_conge_id'])
                ->where('annee', $annee)
                ->first();

            if (! $solde) {
                return redirect()->to('/rh/demandes')
                    ->with('error', 'Solde introuvable pour cet employé.');
            }

            $joursRestants = $solde['jours_attribues'] - $solde['jours_pris'];

            if ($joursRestants < $demande['nb_jours']) {
                return redirect()->to('/rh/demandes')
                    ->with('error', 'Solde insuffisant pour approuver cette demande.');
            }

            $soldeModel->update($solde['id'], [
                'jours_pris' => $solde['jours_pris'] + $demande['nb_jours'],
            ]);

            $congeModel->update($id, [
                'statut' => 'approuvee',
                'commentaire_rh' => 'Demande approuvée par le responsable RH.',
                'traite_par' => session()->get('employe_id') ?? 2,
            ]);

            return redirect()->to('/rh/demandes')
                ->with('success', 'Demande approuvée. Le solde a été mis à jour.');
    }


    public function refuser($id)
    {
        $congeModel = new CongeModel();

        $demande = $congeModel->find($id);

        if (! $demande) {
            return redirect()->to('/rh/demandes')
                ->with('error', 'Demande introuvable.');
        }

        if ($demande['statut'] !== 'en_attente') {
            return redirect()->to('/rh/demandes')
                ->with('error', 'Cette demande a déjà été traitée.');
        }

        $commentaire = $this->request->getPost('commentaire_rh');

        if (empty($commentaire)) {
            $commentaire = 'Demande refusée par le responsable RH.';
        }

        $congeModel->update($id, [
            'statut' => 'refusee',
            'commentaire_rh' => $commentaire,
            'traite_par' => session()->get('employe_id') ?? 2,
        ]);

        return redirect()->to('/rh/demandes')
            ->with('success', 'Demande refusée avec succès.');
    }

    public function soldes()
    {
        $soldeModel = new SoldeModel();

        $data['soldes'] = $soldeModel
            ->select('soldes.*, employes.nom, employes.prenom, departements.nom AS departement_nom, types_conge.libelle AS type_conge')
            ->join('employes', 'employes.id = soldes.employe_id')
            ->join('departements', 'departements.id = employes.departement_id', 'left')
            ->join('types_conge', 'types_conge.id = soldes.type_conge_id')
            ->orderBy('employes.nom', 'ASC')
            ->findAll();

        return view('rh/soldes', $data);
    }

    public function historique()
{
    $congeModel = new CongeModel();

    $data['demandes'] = $congeModel
        ->select('conges.*, employes.nom, employes.prenom, departements.nom AS departement_nom, types_conge.libelle AS type_conge')
        ->join('employes', 'employes.id = conges.employe_id')
        ->join('departements', 'departements.id = employes.departement_id', 'left')
        ->join('types_conge', 'types_conge.id = conges.type_conge_id')
        ->whereIn('conges.statut', ['approuvee', 'refusee', 'annulee'])
        ->orderBy('conges.created_at', 'DESC')
        ->findAll();

    return view('rh/historique', $data);
}
}