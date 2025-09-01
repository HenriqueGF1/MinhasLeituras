<?php

namespace App\Http\Services\Usuario;

use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UsuarioLogout
{
    public function logout(): JsonResponse
    {
        try {
            Auth::logout();

            return response()->json([
                'code' => 200,
                'message' => 'Sucesso logout',
            ]);
        } catch (Exception $exception) {
            throw new Exception(json_encode([
                'msg' => 'Erro ao efetuar logout',
                'erroDev' => $exception->getMessage(),
            ]));
        }
    }
}
