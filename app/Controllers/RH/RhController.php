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

        $data['demandes'] = $congeModel
            ->select('conges.*, employes.nom, employes.prenom, types_conge.libelle AS type_conge')
            ->join('employes', 'employes.id = conges.employe_id')
            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
            ->where('conges.statut', 'en_attente')
            ->findAll();

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
}