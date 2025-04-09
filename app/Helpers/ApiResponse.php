<?php

namespace App\Helpers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiResponse
{
    public static function success($data = [], string $message = 'Operação realizada com sucesso', int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function error(string $message = 'Erro interno no servidor', int $status = 500, $data = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function fromException(\Throwable $exception)
    {
        $status = 500;
        $message = 'Erro interno no servidor';
        $data = [];

        switch (true) {
            case $exception instanceof ValidationException:
                $status = 422;
                $message = 'Erro de validação';
                $data = $exception->errors();
                break;

            case $exception instanceof NotFoundHttpException:
                $status = 404;
                $message = 'Recurso não encontrado';
                break;

            case $exception instanceof AuthenticationException:
                $status = 401;
                $message = 'Não autenticado';
                break;

            case $exception instanceof AuthorizationException:
                $status = 403;
                $message = 'Acesso não autorizado';
                break;

            case $exception instanceof QueryException:
                $status = 500;
                $message = 'Erro no banco de dados';
                $data = [
                    'error' => $exception->getMessage(),
                    'sql' => $exception->getSql(),
                    'bindings' => $exception->getBindings(),
                ];
                break;

            default:
                $message = $exception->getMessage();
                $data = [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => collect($exception->getTrace())->take(2), // trace reduzido
                ];
        }

        Log::channel('daily')->debug('Erro no processamento da requisição', [
            'statusCode' => $status,
            'message' => $message,
            'data' => $data,
        ]);

        return self::error($message, $status, $data);
    }
}
