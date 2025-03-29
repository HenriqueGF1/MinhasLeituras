<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e, Request $request) {

            $mensagem = json_decode($e->getMessage());

            $msg = $mensagem->msg ?? 'Ocorreu um erro inesperado.';
            $erroDev = $mensagem->erroDev ?? $e->getMessage();

            if ($request->is('api/*')) {

                Log::channel('daily')->debug('Erro no processamento da requisição', [
                    'requestUri' => $request->fullUrl(),
                    'statusCode' => 400,
                    'message' => $msg,
                    'messageDev' => $erroDev,
                    'arquivo' => $e->getFile(),
                    'linha' => $e->getLine(),
                    'timestamp' => now(),
                ]);

                return response()->json(
                    [
                        'requestUri' => $request->fullUrl(),
                        'code' => 400,
                        'message' => $msg,
                        'messageDev' => $erroDev,
                        'arquivo' => $e->getFile(),
                        'linha' => $e->getLine(),
                    ],
                    400
                );
            }
        });
    })->create();
