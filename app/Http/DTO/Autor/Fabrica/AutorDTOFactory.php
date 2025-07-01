<?php

namespace App\Http\DTO\Autor\Fabrica;

/**
 * @template T of object
 */
interface AutorDTOFactory
{
    /**
     * @return T
     */
    public function create(array $data);
}
