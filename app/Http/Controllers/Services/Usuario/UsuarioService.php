<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services\Usuario;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsuarioService
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    protected function respondWithToken($token)
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

    public static function getUsuario()
    {
        return Auth::user();
    }

    public function cadastrar($request)
    {
        try {
            DB::beginTransaction();

            $usuario = User::create(
                $request->safe()->all()
            );

            $token = Auth::attempt([
                'email' => $usuario->email,
                'password' => $request->password,
            ]);

            DB::commit();

            return $this->respondWithToken($token);
        } catch (Exception $exception) {
            DB::rollBack();

            throw new Exception(json_encode([
                'msg' => 'Erro ao cadastrar usuario',
                'erroDev' => $exception->getMessage(),
            ]));
        }
    }

    public function login()
    {
        try {
            $credentials = request(['email', 'password']);

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

    public function logout()
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
