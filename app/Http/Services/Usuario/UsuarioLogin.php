<?php

namespace App\Http\Services\Usuario;

use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UsuarioLogin
{
    protected function respondWithToken($token): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
            ],
        ]);
    }

    public function login($request): JsonResponse
    {
        try {
            $credentials = $request->safe()->all();

            if (! $token = Auth::attempt($credentials)) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Usuario ou Senha Incorretos',
                ]);
            }
        } catch (Exception $exception) {
            throw new Exception(json_encode([
                'msg' => 'Erro ao efetuar login',
                'erroDev' => $exception->getMessage(),
            ]));
        }

        return $this->respondWithToken($token);
    }
}
