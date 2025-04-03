<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {})
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $exception, Request $request) {
            // Verifica se a exceção é de validação do Laravel
            if ($exception instanceof Illuminate\Validation\ValidationException) {
                return response()->json(
                    $exception->errors(),
                    422
                );
            }

            // Decodifica a mensagem da exceção (se for um JSON válido)
            $exceptionMessage = json_decode($exception->getMessage());

            $usuarioMensagem = $exceptionMessage->msg ?? 'Ocorreu um erro inesperado.';
            $devMensagem = $exceptionMessage->erroDev ?? $exception->getMessage();

            // Verifica se a requisição é para a API
            if ($request->is('api/*')) {
                Log::channel('daily')->debug('Erro no processamento da requisição', [
                    'request_url' => $request->fullUrl(),
                    'statusCode' => 400,
                    'message' => $usuarioMensagem,
                    'mgs_dev' => $devMensagem,
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'timestamp' => now(),
                ]);

                return response()->json(
                    [
                        'statusCode' => 400,
                        'message' => $usuarioMensagem,
                        'request_url' => $request->fullUrl(),
                        'mgs_dev' => $devMensagem,
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                    ],
                    400
                );
            }
        });
    })->create();
