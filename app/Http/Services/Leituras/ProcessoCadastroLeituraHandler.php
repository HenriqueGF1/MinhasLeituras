<?php

namespace App\Http\Services\Leituras;

use App\Http\DTO\CadastroLeituraDto;

// padrao Chain of Responsibility
abstract class ProcessoCadastroLeituraHandler
{
    protected ?ProcessoCadastroLeituraHandler $next = null;

    // Define o próximo processar na cadeia
    public function setNext(ProcessoCadastroLeituraHandler $handler): ProcessoCadastroLeituraHandler
    {
        $this->next = $handler;

        return $this;
    }

    // Processa a requisição ou passa para o próximo
    abstract public function processar(CadastroLeituraDto $data): CadastroLeituraDto;
}
