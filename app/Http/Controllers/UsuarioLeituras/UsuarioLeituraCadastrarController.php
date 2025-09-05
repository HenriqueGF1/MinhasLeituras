<?php

namespace App\Http\Controllers\UsuarioLeituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\UsuarioLeitura\UsuarioLeituraCadastroDTO;
use App\Http\Requests\Usuario\UsuarioLeituraCadastroRequest;
use App\Http\Services\Usuario\Leitura\UsuarioLeituraCadastro;
use Illuminate\Http\JsonResponse;

class UsuarioLeituraCadastrarController extends Controller
{
    public function __construct(protected UsuarioLeituraCadastro $service) {}

    /**
     * @OA\Post(
     *   path="/api/usuario-leitura",
     *   summary="Cadastrar Leitura do Usuário",
     *   description="Cadastrar ou atualizar a leitura do usuário",
     *   tags={"Usuario Leituras"},
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Parameter(
     *      name="token",
     *      in="query",
     *      required=true,
     *      description="Token de autenticação do usuário",
     *
     *      @OA\Schema(type="string")
     *   ),
     *
     *   @OA\RequestBody(
     *     required=true,
     *
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *
     *       @OA\Schema(
     *         type="object",
     *         required={"id_leitura","id_status_leitura"},
     *
     *         @OA\Property(property="id_leitura", type="integer", description="ID da leitura do usuário"),
     *         @OA\Property(property="id_status_leitura", type="integer", description="Status da leitura: 1=Não iniciado, 2=Em leitura, 3=Concluído")
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Leitura cadastrada com sucesso",
     *
     *     @OA\JsonContent(
     *       type="object",
     *
     *       @OA\Property(property="success", type="boolean"),
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="data", type="object", description="Dados da leitura cadastrada")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=401,
     *     description="Não autorizado, token inválido ou ausente"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Erro interno no servidor"
     *   )
     * )
     */
    public function __invoke(UsuarioLeituraCadastroRequest $request): JsonResponse
    {
        try {
            $usuarioLeituraExcluirDTO = new UsuarioLeituraCadastroDTO($request->safe()->all());

            $usuarioLeitura = $this->service->cadastrarLeituraDoUsuario($usuarioLeituraExcluirDTO);

            return ApiResponse::success(
                $usuarioLeitura,
                'Leitura Cadastrada com sucesso'
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
