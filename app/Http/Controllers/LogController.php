<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerResource;
use App\Services\LogService;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function __construct(private LogService $_service){}

    public function index(Request $request)
    {
        $data = $this->_service->lista($request->all());
        return (new AnswerResource(collect($data)))->toJsonResponse();
    }

    public function show(Log $log)
    {
        $data = $this->_service->exibir($log->id);
        return (new AnswerResource(collect($data)))->toJsonResponse();
    }
}
