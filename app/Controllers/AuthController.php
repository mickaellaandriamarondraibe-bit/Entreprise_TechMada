<?php
namespace App\Controllers;
use App\Models\EmployeModel;

class AuthController extends BaseController
{
    public function loginPage()
    {
        return view('auth/login');
    }

    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model   = new EmployeModel();
        $employe = $model->where('email', $email)->where('actif', 1)->first();

        if (! $employe || ! password_verify($password, $employe['password'])) {
            return redirect()->to('/login')->with('error', 'Email ou mot de passe incorrect.');
        }

        // Stocker en session selon le todo (image 1)
        session()->set([
            'employe_id' => $employe['id'],
            'role'       => $employe['role'],
            'nom'        => $employe['nom'],
            'prenom'     => $employe['prenom'],
        ]);

        // Redirection selon le rôle
        return match($employe['role']) {
            'rh'    => redirect()->to('/rh'),
            'admin' => redirect()->to('/admin'),
            default => redirect()->to('/employe'),
        };
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}