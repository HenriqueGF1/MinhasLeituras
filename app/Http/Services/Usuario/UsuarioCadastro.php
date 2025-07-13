<?php

namespace App\Http\Services\Usuario;

use App\Http\DTO\Usuario\UsuarioCadastroDTO;
use App\Models\User;
use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsuarioCadastro
{
    public function __construct(protected User $model) {}

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

    public function cadastroDeUsuario(UsuarioCadastroDTO $dto): JsonResponse
    {
        try {
            DB::beginTransaction();

            $this->model->create($dto->toArray());

            DB::commit();

            $token = Auth::attempt([
                'email' => $dto->email,
                'password' => $dto->password,
            ]);

            DB::commit();

            return $this->respondWithToken($token);
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
