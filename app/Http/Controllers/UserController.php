<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\Usuario\UsuarioService;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $service;

    public function __construct()
    {
        $this->service = new UsuarioService();
    }

    public function teste()
    {
        return 'Aqui';
    }

    public function login()
    {
        return $this->service->login();
    }

    public function cadastrar(UserRequest $request)
    {
        return $this->service->cadastrar($request);
    }

    public function logout()
    {
        return $this->service->logout();
    }
}
