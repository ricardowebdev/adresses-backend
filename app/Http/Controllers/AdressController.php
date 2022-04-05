<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdressRequest;
use App\Services\AdressesService;

class AdressController extends Controller
{
    public function index(AdressesService $service)
    {
        $adress = $service->list();

        return response($adress, 200);
    }

    public function add(StoreAdressRequest $request, AdressesService $service)
    {
        $adress = $service->add($request);

        return response(
            $adress ? $adress : 'Failed adding Adress',
            $adress ? 200 : 400
        );
    }

    public function update($id, StoreAdressRequest $request, AdressesService $service)
    {
        $adress = $service->update($id, $request);
        $status = $adress ? 200 : 404;
        $response = $adress ? $adress : 'Adress not found';

        return response($response, $status);
    }

    public function delete($id, AdressesService $service)
    {
        $adress = $service->delete($id);
        $status = $adress ? 200 : 404;
        $response = $adress ? $adress : 'Adress not found';

        return response($response, $status);
    }

    public function get($id, AdressesService $service)
    {
        $adress = $service->get($id);
        $status = $adress ? 200 : 404;
        $response = $adress ? $adress : 'Adress not found';

        return response($response, $status);
    }
}
