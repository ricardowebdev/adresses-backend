<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdressRequest;
use App\Services\AddressesMongoService;

class AddressMongoController extends Controller
{
    public function index(AddressesMongoService $service)
    {
        $adress = $service->list();

        return response($adress, 200);
    }

    public function add(StoreAdressRequest $request, AddressesMongoService $service)
    {
        $adress = $service->add($request);

        return response(
            $adress ? $adress : 'Failed adding Adress',
            $adress ? 200 : 400
        );
    }

    public function update($id, StoreAdressRequest $request, AddressesMongoService $service)
    {
        $adress = $service->update($id, $request);
        $status = isset($adress->id) ? 200 : 404;
        $response = isset($adress->id) ? $adress : 'Adress not found';

        return response($response, $status);
    }

    public function delete($id, AddressesMongoService $service)
    {
        $result = $service->delete($id);
        $status = $result ? 200 : 404;
        $response = $result ? 'Adress removed successfully' : 'Adress not found';

        return response($response, $status);
    }

    public function get($id, AddressesMongoService $service)
    {
        $adress = $service->get($id);
        $status = count($adress) ? 200 : 404;
        $response = count($adress) ? $adress : 'Adress not found';

        return response($response, $status);
    }
}
