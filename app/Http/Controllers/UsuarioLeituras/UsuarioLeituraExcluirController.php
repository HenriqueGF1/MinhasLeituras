<?php

namespace App\Http\Controllers\UsuarioLeituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\UsuarioLeitura\UsuarioLeituraExcluirDTO;
use App\Http\Requests\Usuario\UsuarioLeituraExcluirRequest;
use App\Http\Services\Usuario\Leitura\UsuarioLeituraExcluir;
use Illuminate\Http\JsonResponse;

class UsuarioLeituraExcluirController extends Controller
{
    public function __construct(protected UsuarioLeituraExcluir $service) {}

    /**
     * @OA\Delete(
     *   path="/api/usuario-leitura/{id_usuario_leitura}",
     *   summary="Excluir Leitura do Usuário",
     *   description="Excluir Leitura do Usuário pelo ID",
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
     *   @OA\Parameter(
     *      name="id_usuario_leitura",
     *      in="path",
     *      required=true,
     *      description="ID da leitura do usuário a ser excluída",
     *
     *      @OA\Schema(type="integer")
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Leitura excluída com sucesso",
     *
     *     @OA\JsonContent(
     *       type="object",
     *
     *       @OA\Property(property="success", type="boolean"),
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="data", type="object", description="Dados adicionais, se houver")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=401,
     *     description="Não autorizado, token inválido ou ausente"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Leitura não encontrada"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Erro interno no servidor"
     *   )
     * )
     */
    public function __invoke(UsuarioLeituraExcluirRequest $request): JsonResponse
    {
        try {
            $usuarioLeituraExcluirDTO = new UsuarioLeituraExcluirDTO($request->safe()->all());

            $this->service->usuarioLeituraExcluirLeitura($usuarioLeituraExcluirDTO);

            return ApiResponse::success(
                [],
                'Leitura Excluida com sucesso'
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
