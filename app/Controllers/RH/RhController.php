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
}