<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Services\Usuario\UsuarioLogout;

class UsuarioLogoutController extends Controller
{
    public function __construct(protected UsuarioLogout $usuarioLogoutService) {}

    public function __invoke()
    {
        return $this->usuarioLogoutService->logout();
    }
}
