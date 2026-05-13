<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CongeModel;
use App\Models\SoldeModel;
use App\Models\EmployeModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $congeModel = new CongeModel();
        $soldeModel = new SoldeModel();
        $employeModel = new EmployeModel();

        $data['nbEmployes'] = $employeModel->where('actif', 1)->countAllResults();
        $data['nbAttente'] = $congeModel->where('statut', 'en_attente')->countAllResults();
        $data['nbApprouvees'] = $congeModel->where('statut', 'approuvee')->countAllResults();
        $data['nbRefusees'] = $congeModel->where('statut', 'refusee')->countAllResults();

        $data['demandesRecentes'] = $congeModel
            ->select('conges.*, employes.nom, employes.prenom, types_conge.libelle AS type_conge')
            ->join('employes', 'employes.id = conges.employe_id')
            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
            ->orderBy('conges.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        return view('admin/dashboard', $data);
    }
}