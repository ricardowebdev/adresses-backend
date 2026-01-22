<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerResource;
use App\Services\EnderecoService;
use App\Http\Requests\EnderecoRequest;
use App\Http\Requests\EnderecoListRequest;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{

    public function __construct(private EnderecoService $_service){}

    public function index(EnderecoListRequest $request)
    {
        $data = $this->_service->index($request->all());
        return (new AnswerResource(collect($data)))->toJsonResponse();
    }

    public function show(string $id)
    {
        $data = $this->_service->show($id);
        return (new AnswerResource(collect($data)))->toJsonResponse();
    }

    public function update(EnderecoRequest $request, string $id)
    {
        $data = $this->_service->update($request->all(), $id);
        return (new AnswerResource(collect($data)))->toJsonResponse();
    }

    public function destroy(string $id)
    {
        $data = $this->_service->destroy($id);
        return (new AnswerResource(collect($data)))->toJsonResponse();
    }

    public function store(EnderecoRequest $request)
    {
        $data = $this->_service->store($request->all());
        return (new AnswerResource(collect($data)))->toJsonResponse();
    }

    public function excel(Request $request)
    {
        return $this->_service->excel($request->all());
    }   
}
