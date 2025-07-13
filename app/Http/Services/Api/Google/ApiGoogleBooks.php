<?php

namespace App\Http\Services\Api\Google;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ApiGoogleBooks implements IsbnApiInterface
{
    protected $apiKey;

    protected $baseUrl = 'https://www.googleapis.com/books/v1/volumes';

    public function __construct()
    {
        $this->apiKey = config('services.google_books.key');
    }

    public function procurarInformacaoLeituraPorIsbn(string $isbn): JsonResponse
    {
        $response = Http::get($this->baseUrl, [
            'q' => 'isbn:' . $isbn,
            'key' => $this->apiKey,
            'maxResults' => 1,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (! empty($data['items'][0])) {
                return response()->json([
                    'status' => 'success',
                    'livro' => $data['items'][0],
                ], 200);
            }

            return response()->json([
                'status' => 'not_found',
                'mensagem' => 'Livro não encontrado para o ISBN informado.',
            ], 404);
        }

        return response()->json([
            'status' => 'error',
            'mensagem' => 'Erro ao consultar a API de livros.',
            'codigo_http' => $response->status(),
        ], 502);
    }
}
