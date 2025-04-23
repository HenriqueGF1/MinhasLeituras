<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Services\UsuarioService\UsuarioService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UsuarioService $service)
    {
        $this->service = $service;
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
