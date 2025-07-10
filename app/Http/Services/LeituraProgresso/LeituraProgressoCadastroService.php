<?php

namespace App\Http\Services\LeituraProgresso;

use App\Http\DTO\LeituraProgresso\LeituraProgressoCadastroDTO;
use App\Models\LeituraProgresso;
use Exception;
use Illuminate\Support\Facades\DB;

class LeituraProgressoCadastroService
{
    public function __construct(protected LeituraProgresso $leituraProgresssoModel) {}

    public function cadastrarProgresso(LeituraProgressoCadastroDTO $dtoLeituraProgressoDTO): LeituraProgresso
    {
        // dd($dtoLeituraProgressoDTO->toArray());

        try {
            DB::beginTransaction();

            $leituraProgresso = $this->leituraProgresssoModel->create($dtoLeituraProgressoDTO->toArray());

            DB::commit();

            return $leituraProgresso;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
