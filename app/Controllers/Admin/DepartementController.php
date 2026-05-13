<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DepartementModel;

class DepartementController extends BaseController
{
    public function index()
    {
        $model = new DepartementModel();

        return view('admin/departements/index', [
            'departements' => $model->getAll(),
        ]);
    }

    public function create()
    {
        return view('admin/departements/create');
    }

    public function store()
    {
        $model = new DepartementModel();

        $nom = trim($this->request->getPost('nom'));

        if (empty($nom)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Le nom est obligatoire.');
        }

        $model->insert(['nom' => $nom]);

        return redirect()->to(base_url('admin/departements'))
                         ->with('success', 'Département créé.');
    }

    public function edit($id)
    {
        $model = new DepartementModel();
        $departement = $model->getById($id);

        if (! $departement) {
            return redirect()->to(base_url('admin/departements'))
                             ->with('error', 'Département introuvable.');
        }

        return view('admin/departements/edit', [
            'departement' => $departement,
        ]);
    }

    public function update($id)
    {
        $model = new DepartementModel();

        $nom = trim($this->request->getPost('nom'));

        if (empty($nom)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Le nom est obligatoire.');
        }

        $model->update($id, ['nom' => $nom]);

        return redirect()->to(base_url('admin/departements'))
                         ->with('success', 'Département mis à jour.');
    }

    public function delete($id)
    {
        $model = new DepartementModel();
        $model->delete($id);

        return redirect()->to(base_url('admin/departements'))
                         ->with('success', 'Département supprimé.');
    }
}