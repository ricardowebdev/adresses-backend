<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\StatesService;

class AdressController extends Controller
{
    public function index(StatesService $service)
    {
        $states = $service->list();

        return response($states, 200);
    }
}
