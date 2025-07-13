<?php

namespace App\Http\Services\Api\Google;

use Illuminate\Http\JsonResponse;

interface IsbnApiInterface
{
    public function procurarInformacaoLeituraPorIsbn(string $isbn): JsonResponse;
}
