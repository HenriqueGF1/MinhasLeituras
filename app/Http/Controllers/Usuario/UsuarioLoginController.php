<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\UsuarioLoginRequest;
use App\Http\Services\Usuario\UsuarioLogin;

class UsuarioLoginController extends Controller
{
    public function __construct(protected UsuarioLogin $usuarioLoginService) {}

    public function __invoke(UsuarioLoginRequest $request)
    {
        return $this->usuarioLoginService->login($request);
    }
}
