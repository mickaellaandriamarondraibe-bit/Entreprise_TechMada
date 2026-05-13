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

    public function employes()
{
    $employeModel = new EmployeModel();

    $data['employes'] = $employeModel
        ->orderBy('id', 'DESC')
        ->findAll();

    return view('admin/employes', $data);
}

public function createEmploye()
{
    return view('admin/employe_form', [
        'mode' => 'create',
        'employe' => null,
    ]);
}

public function storeEmploye()
{
    $employeModel = new EmployeModel();

    $data = [
        'nom' => $this->request->getPost('nom'),
        'prenom' => $this->request->getPost('prenom'),
        'email' => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role' => $this->request->getPost('role'),
        'departement_id' => $this->request->getPost('departement_id'),
        'date_embauche' => $this->request->getPost('date_embauche'),
        'actif' => $this->request->getPost('actif') ?? 1,
    ];

    $employeModel->insert($data);

    return redirect()->to('/admin/employes')
        ->with('success', 'Employé créé avec succès.');
}

public function editEmploye($id)
{
    $employeModel = new EmployeModel();

    $employe = $employeModel->find($id);

    if (! $employe) {
        return redirect()->to('/admin/employes')
            ->with('error', 'Employé introuvable.');
    }

    return view('admin/employe_form', [
        'mode' => 'edit',
        'employe' => $employe,
    ]);
}

public function updateEmploye($id)
{
    $employeModel = new EmployeModel();

    $employe = $employeModel->find($id);

    if (! $employe) {
        return redirect()->to('/admin/employes')
            ->with('error', 'Employé introuvable.');
    }

    $data = [
        'nom' => $this->request->getPost('nom'),
        'prenom' => $this->request->getPost('prenom'),
        'email' => $this->request->getPost('email'),
        'role' => $this->request->getPost('role'),
        'departement_id' => $this->request->getPost('departement_id'),
        'date_embauche' => $this->request->getPost('date_embauche'),
        'actif' => $this->request->getPost('actif') ?? 0,
    ];

    $password = $this->request->getPost('password');

    if (! empty($password)) {
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    $employeModel->update($id, $data);

    return redirect()->to('/admin/employes')
        ->with('success', 'Employé modifié avec succès.');
}

public function deleteEmploye($id)
{
    $employeModel = new EmployeModel();

    $employe = $employeModel->find($id);

    if (! $employe) {
        return redirect()->to('/admin/employes')
            ->with('error', 'Employé introuvable.');
    }

    // Désactivation, pas suppression définitive
    $employeModel->update($id, [
        'actif' => 0,
    ]);

    return redirect()->to('/admin/employes')
        ->with('success', 'Employé désactivé avec succès.');
}
}