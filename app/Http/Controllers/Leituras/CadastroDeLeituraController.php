<?php

namespace App\Http\Controllers\Leituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\Leitura\CadastroLeituraDto;
use App\Http\Facades\Leitura\CadastramentoDeLeituraFacade;
use App\Http\Requests\Leitura\LeiturasRequest;
use App\Http\Resources\Leitura\LeiturasResource;
use Illuminate\Http\JsonResponse;

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class CadastroDeLeituraController extends Controller
{
    public function __construct(
        protected CadastramentoDeLeituraFacade $cadastramentoDeLeituraFacade
    ) {}

    /**
     * @OA\Post(
     *   path="/api/leituras",
     *   summary="Criar uma nova leitura",
     *   description="Endpoint para cadastrar uma nova leitura com informações do livro",
     *   tags={"Leituras"},
     *
     *   @OA\RequestBody(
     *     required=true,
     *
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *
     *       @OA\Schema(
     *         type="object",
     *         required={},
     *
     *         @OA\Property(property="token", type="string", description="Token de autenticação"),
     *         @OA\Property(property="titulo", type="string", description="Título do livro"),
     *         @OA\Property(property="descricao", type="string", description="Descrição do livro"),
     *         @OA\Property(property="capa", type="string", format="url", description="URL da capa"),
     *         @OA\Property(property="capa_arquivo", type="string", format="binary", description="Upload do arquivo da capa"),
     *         @OA\Property(property="id_editora", type="integer", description="ID da editora"),
     *         @OA\Property(property="descricao_editora", type="string", description="Descrição da editora"),
     *         @OA\Property(property="id_autor", type="integer", description="ID do autor"),
     *         @OA\Property(property="nome_autor", type="string", description="Nome do autor"),
     *         @OA\Property(property="data_publicacao", type="string", format="date", description="Data de publicação"),
     *         @OA\Property(property="qtd_capitulos", type="integer", description="Quantidade de capítulos"),
     *         @OA\Property(property="qtd_paginas", type="integer", description="Quantidade de páginas"),
     *         @OA\Property(property="isbn", type="string", description="ISBN do livro"),
     *         @OA\Property(property="id_status_leitura", type="integer", description="Status da leitura: 1=Não iniciado, 2=Em leitura, 3=Concluído"),
     *         @OA\Property(
     *            property="id_genero",
     *            type="array",
     *
     *            @OA\Items(type="integer"),
     *            description="Lista de IDs de gêneros literários"
     *         )
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=201,
     *     description="Leitura criada com sucesso",
     *
     *     @OA\JsonContent(
     *       type="object",
     *
     *       @OA\Property(property="success", type="boolean"),
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="data", ref="#")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=400,
     *     description="Erro de validação nos campos enviados"
     *   ),
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
    public function __invoke(LeiturasRequest $request): JsonResponse
    {
        try {
            $dtoLeitura = new CadastroLeituraDto($request->validated());

            $leitura = $this->cadastramentoDeLeituraFacade->processoDeCadastroDeLeitura($dtoLeitura);

            return ApiResponse::success(
                new LeiturasResource($leitura),
                'Leitura cadastrada com sucesso',
                201
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
