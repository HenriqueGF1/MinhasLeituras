<?php

namespace App\Http\Controllers\Services\Usuario;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsuarioService
{

    private $model;
    public function __construct()
    {
        $this->model = User::class;
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
        // try {
        return response()->json(Auth::user());
        // } catch (\Exception $exception) {
        //     throw new ErroGeralException($exception->getMessage());
        // }
    }

    public function cadastrar($request)
    {

        $usuario = User::create([
            "nome" => $request->nome,
            "email" => $request->email,
            "password" => $request->password,
            "data_nascimento" => $request->data_nascimento,
        ]);

        $token = Auth::attempt([
            "email" => $usuario->email,
            "password" => $request->password,
        ]);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'code' => 200,
                'message' => 'Usuario ou Senha Incorretos'
            ]);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        // try {

        Auth::logout();

        return response()->json([
            'code' => 200,
            'message' => 'Sucesso logout'
        ]);
        // } catch (\Exception $exception) {
        //     throw new ErroGeralException($exception->getMessage());
        // }
    }
}
