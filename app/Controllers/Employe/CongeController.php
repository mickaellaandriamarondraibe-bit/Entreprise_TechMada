<?php
namespace App\Controllers\Employe;

use App\Controllers\BaseController;
use App\Models\SoldeModel;   // ← manquait
use App\Models\CongeModel;   // ← manquait

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
}