<?php

namespace App\Http\Services\Leituras;

use App\Http\DTO\Leitura\LeituraCadastroDTO;
use App\Models\Leituras;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LeituraCadastro
{
    public function __construct(protected Leituras $model) {}

    public function cadastroDeLeitura(LeituraCadastroDTO $leituraDto): Leituras
    {
        try {
            DB::beginTransaction();

            $dados = $leituraDto->toArray();

            if (! empty($leituraDto->capa_arquivo) && $leituraDto->capa_arquivo instanceof UploadedFile) {
                $path = $leituraDto->capa_arquivo->store('capas', 'public');
                $url = Storage::url($path);
                $dados['capa'] = $url;
            }

            $leitura = $this->model->create($dados);

            DB::commit();

            return $leitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
