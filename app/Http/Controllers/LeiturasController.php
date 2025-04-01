<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\Leituras\LeiturasService;
use App\Http\Requests\LeiturasRequest;
use App\Http\Resources\LeiturasResource;

class LeiturasController extends Controller
{

    private $service;
    public function __construct()
    {
        $this->service = new LeiturasService();
    }
    public function index()
    {
        return LeiturasResource::collection(
            $this->service->pesquisarLeituras()
        );
    }

    public function store(LeiturasRequest $request)
    {
        return new LeiturasResource(
            $this->service->cadastrarLeitura($request)
        );
    }


    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
