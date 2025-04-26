<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\IsbnRequest;
use App\Http\Requests\LeiturasRequest;
use App\Http\Resources\LeiturasResource;
use App\Http\Services\Leituras\LeiturasService;

/**
 * @OA\PathItem(path="/api/leituras")
 */
class LeiturasController extends Controller
{
    protected $service;

    public function __construct(LeiturasService $service)
    {
        $this->service = $service;
    }

    /**
     * Listar todas as leituras.
     *
     * @OA\Get(
     *     path="/api/leituras",
     *     summary="Retorna a lista de leituras",
     *     tags={"Leituras"},
     *
     *     @OA\Response(response=200, description="Lista de leituras")
     * )
     */
    public function index()
    {
        return LeiturasResource::collection(
            $this->service->pesquisarLeituras()
        );
    }

    public function pesquisaIsbnBase(IsbnRequest $request)
    {
        return new LeiturasResource(
            $this->service->pesquisaIsbnBase($request)
        );
    }

    /**
     * Cadastrar uma nova leitura.
     *
     * @OA\Post(
     *     path="/api/leituras",
     *     summary="Cria uma nova leitura",
     *     tags={"Leituras"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"titulo", "descricao", "id_editora", "id_autor", "data_publicacao", "qtd_capitulos", "qtd_paginas", "isbn"},
     *
     *             @OA\Property(property="id_leitura", type="integer", example=1),
     *             @OA\Property(property="titulo", type="string", example="O Senhor dos Anéis"),
     *             @OA\Property(property="descricao", type="string", example="Um livro sobre uma jornada épica."),
     *             @OA\Property(property="capa", type="string", format="url", example="https://example.com/capa.jpg"),
     *             @OA\Property(property="id_editora", type="integer", example=10),
     *             @OA\Property(property="id_autor", type="integer", example=5),
     *             @OA\Property(property="data_publicacao", type="string", format="date", example="1954-07-29"),
     *             @OA\Property(property="qtd_capitulos", type="integer", example=22),
     *             @OA\Property(property="qtd_paginas", type="integer", example=423),
     *             @OA\Property(property="isbn", type="string", example="978-85-333-0227-0"),
     *             @OA\Property(property="data_inicio_leitura", type="string", format="date", example="2024-01-15"),
     *             @OA\Property(property="id_status_leitura", type="integer", example=2),
     *             @OA\Property(property="data_registro", type="string", format="date-time", example="2024-03-20T14:30:00Z")
     *         )
     *     ),
     *
     *     @OA\Response(response=201, description="Leitura criada com sucesso")
     * )
     */
    public function store(LeiturasRequest $request)
    {
        try {
            $leitura = $this->service->cadastrarLeitura((array) $request->safe()->all());

            return ApiResponse::success(new LeiturasResource($leitura), 'Leitura cadastrada com sucesso');
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
