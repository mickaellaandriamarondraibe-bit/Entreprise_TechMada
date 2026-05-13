<?php
namespace App\Controllers\Employe;

use App\Controllers\BaseController;
use App\Models\SoldeModel;
use App\Models\CongeModel;

class DashboardController extends BaseController
{
    public function index()
        {
            $employe_id = session()->get('employe_id');

            $soldeModel = new SoldeModel();
            $congeModel = new CongeModel();

            return view('employe/dashboard', [
                'soldes'             => $soldeModel->getSoldesAvecType($employe_id),
                'stats'              => $congeModel->getStats($employe_id),
                'dernieres_demandes' => $congeModel->getDernieresDemandes($employe_id),
            ]);
        }
}