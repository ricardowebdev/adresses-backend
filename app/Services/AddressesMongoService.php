<?php

namespace App\Services;

use App\Services\AdressesService;
use App\Models\addressMongo;


class AddressesMongoService
{
    public function list()
    {
        $adresses = addressMongo::get()
            ->where('active', 1);
            
        return $adresses;
    }

    public function add($data)
    {
        $address = false;
        $service  = new AdressesService();
        $response = $service->add($data);
       
        if ($response) {
            $address = addressMongo::create([
                'cep'              => $data->cep,
                'estado'           => $data->estado,
                'cidade'           => $data->cidade,
                'bairro'           => $data->bairro,
                'endereco'         => $data->endereco,
                'numero'           => $data->numero,
                'nome_contato'     => $data->nome_contato,
                'email_contato'    => $data->email_contato,
                'telefone_contato' => $data->telefone_contato,
                'legacy_id'        => $response->id,
                'active'           => 1
            ]);

            $address = addressMongo::find($address);
        }

        return $address;
    }

    public function update($id, $data)
    {
        $address  = false;
        $service  = new AdressesService();
        $response = $service->update($id, $data);

        if ($response) {
            $address = addressMongo::where('legacy_id', $id);

            if ($address) {
                $address = $address->update([
                    'cep' => $data->cep,
                    'estado' => $data->estado,
                    'cidade' => $data->cidade,
                    'bairro' => $data->bairro,
                    'endereco' => $data->endereco,
                    'numero' => $data->numero,
                    'nome_contato' => $data->nome_contato,
                    'email_contato' => $data->email_contato,
                    'telefone_contato' => $data->telefone_contato,
                    'legacy_id'        => $response->id,
                    'active' => isset($data->active) ? $data->active : 0
                ]);

                $address = addressMongo::find($address);
            }
        }


        return $address ?? [];
    }

    public function delete($id)
    {
        $result = 0;
        $service  = new AdressesService();
        $response = $service->delete($id);

        if ($response) {
            $address = addressMongo::where('legacy_id', $id)->first();
            if ($address) {
                $address->active = !$address->active;
                $result = $address->save();            
            }
    
            return $result;
        }
    }

    public function get($id)
    {
        $adress = addressMongo::where('legacy_id', $id)
            ->where('active', 1)
            ->get();
            

        return $adress;
    }
}
