<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function loginPage()
    {
        return view('auth/login');
    }

    public function login()
    {
        // Handle login logic here
    }
}
