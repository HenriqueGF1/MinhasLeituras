<?php

namespace App\Http\Services\Leituras\LeituraProgresso;

use App\Http\DTO\LeituraProgresso\LeituraProgressoCadastroDTO;
use App\Models\LeituraProgresso;
use Exception;
use Illuminate\Support\Facades\DB;

class LeituraProgressoCadastro
{
    public function __construct(
        protected LeituraProgresso $leituraProgressoModel
    ) {}

    public function cadastrarProgresso(LeituraProgressoCadastroDTO $dto): LeituraProgresso
    {
        try {
            DB::beginTransaction();

            $leituraProgresso = $this->leituraProgressoModel->create($dto->toArray());

            DB::commit();

            return $leituraProgresso;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
