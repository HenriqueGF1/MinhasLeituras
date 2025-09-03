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
     *     path="/api/leituras/cadastrar",
     *     summary="Cadastra uma nova leitura",
     *     tags={"Leituras"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *
     *             @OA\Schema(
     *                 required={"titulo", "descricao", "nome_autor", "data_publicacao", "id_status_leitura"},
     *
     *                 @OA\Property(
     *                     property="token",
     *                     type="string",
     *                     example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
     *                     description="Token JWT para autenticação (normalmente enviado no cabeçalho Authorization, mas pode ser enviado aqui se necessário)"
     *                 ),
     *                 @OA\Property(property="id_usuario", type="int", example="1"),
     *                 @OA\Property(property="titulo", type="string", example="Percy Jackson e o Ladrão de Raios"),
     *                 @OA\Property(property="descricao", type="string", example="Escrito por Rick Riordan..."),
     *                 @OA\Property(
     *                     property="capa",
     *                     type="string",
     *                     format="binary",
     *                     description="Arquivo de imagem da capa"
     *                 ),
     *                 @OA\Property(property="descricao_editora", type="string", example="Intrínseca"),
     *                 @OA\Property(property="nome_autor", type="string", example="Rick Riordan"),
     *                 @OA\Property(
     *                     property="data_publicacao",
     *                     type="string",
     *                     format="date",
     *                     example="2005-06-28"
     *                 ),
     *                 @OA\Property(property="qtd_capitulos", type="integer", example=22),
     *                 @OA\Property(property="qtd_paginas", type="integer", example=400),
     *                 @OA\Property(property="isbn", type="string", example="9788598078394"),
     *                 @OA\Property(
     *                     property="data_registro",
     *                     type="string",
     *                     format="date",
     *                     example="2005-06-28"
     *                 ),
     *                 @OA\Property(
     *                     property="id_status_leitura",
     *                     type="integer",
     *                     example=2,
     *                     description="Status da leitura: 1=Para Ler, 2=Lendo, 3=Concluído"
     *                 ),
     *                 @OA\Property(
     *                     property="id_genero",
     *                     type="array",
     *
     *                     @OA\Items(type="integer"),
     *                     example={8, 9},
     *                     description="IDs dos gêneros (enviar como array)"
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Leitura cadastrada com sucesso",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Leitura cadastrada com sucesso"),
     *             @OA\Property(property="status", type="integer", example=201),
     *             @OA\Property(property="data", ref="/components/schemas/LeituraResource")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado - Token inválido ou não fornecido"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
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

/**
 * @OA\Schema(
 *     schema="LeituraResource",
 *
 *     @OA\Property(property="titulo", type="string"),
 *     @OA\Property(property="descricao", type="string"),
 *     @OA\Property(property="capa_url", type="string", description="URL da imagem da capa"),
 *     @OA\Property(property="descricao_editora", type="string"),
 *     @OA\Property(property="nome_autor", type="string"),
 *     @OA\Property(property="data_publicacao", type="string", format="date"),
 *     @OA\Property(property="qtd_capitulos", type="integer"),
 *     @OA\Property(property="qtd_paginas", type="integer"),
 *     @OA\Property(property="isbn", type="string"),
 *     @OA\Property(property="data_registro", type="string", format="date"),
 *     @OA\Property(property="usuario", type="object", description="Dados do usuário"),
 *     @OA\Property(property="status_leitura", type="object", description="Status da leitura"),
 *     @OA\Property(property="generos", type="array", @OA\Items(type="object"), description="Gêneros do livro")
 * )
 */
