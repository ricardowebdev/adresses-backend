<?php

namespace App\Services;

use App\Models\Adresses;
use App\Services\MongoAdressService;

class AdressesService
{
    public function list()
    {
        $adresses = Adresses::get()->where('active', 1);
        return $adresses;
    }

    public function add($data)
    {
        $adress = Adresses::create([
            'cep' => $data->cep,
            'estado' => $data->estado,
            'cidade' => $data->cidade,
            'bairro' => $data->bairro,
            'endereco' => $data->endereco,
            'numero' => $data->numero,
            'nome_contato' => $data->nomeContato,
            'email_contato' => $data->emailContato,
            'telefone_contato' => $data->telefoneContato,
            'active' => 1
        ]);

        return $adress;
    }

    public function update($id, $data)
    {
        $adress = Adresses::find($id);

        if ($adress) {
            $adress->update([
                'cep' => $data->cep,
                'estado' => $data->estado,
                'cidade' => $data->cidade,
                'bairro' => $data->bairro,
                'endereco' => $data->endereco,
                'numero' => $data->numero,
                'nome_contato' => $data->nomeContato,
                'email_contato' => $data->emailContato,
                'telefone_contato' => $data->telefoneContato,
                'active' => isset($data->active) ? $data->active : 0
            ]);
        }

        return $adress ?? [];
    }

    public function delete($id)
    {
        $result = 0;

        $adress = Adresses::find($id);
        if ($adress) {
            $result = $adress->update([
                'active' => 0
            ]);
        }

        return $result;
    }

    public function get($id)
    {
        $adress = Adresses::where('id', $id)
            ->where('active', 1)
            ->get();

        return $adress;
    }
}
