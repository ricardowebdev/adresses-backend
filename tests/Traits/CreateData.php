<?php

namespace Tests\Traits;

use App\Models\Perfil;
use App\Models\Cliente;
use App\Models\PerfilPermissao;
use App\Models\Permissao;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait CreateData
{
    protected Array|null $_requestPerfil;
    protected Perfil|null $_perfil;
    protected Array|null $_requestCliente;
    protected Cliente|null $_cliente;
    protected Array|null $_requestUser;
    protected User|null $_user;
    protected string $_token;
    
    protected function all()
    {
        $this->createUserAuthData();
    }

    protected function createUserAuthData()
    {
        $this->getPerfil();
        $this->getCliente();
        $this->getUser();
    }

    private function getPerfil($novo = false)
    {
        $this->_perfil = Perfil::updateOrCreate(
            ['nome' => 'administrador', 'id' => 1],
            ['nome' => 'administrador', 'id' => 1]
        );
    }

    private function getCliente()
    {
        $this->_cliente = Cliente::updateOrCreate(
            [
                'nome' => "cliente_2000"
            ],
            [
                'nome' => "cliente_2000",
                'descricao' => "blabla",
                'logradouro' => "blabla",
                'numero' => "33",
                'complemento' => "",
                'cidade' => "teste",
                'bairro' => "teste",
                'estado' => "SP",
                'pais' => "BR",
                'postal_code' => "09941070",
                'telefone' => "11992454885",
                'documento' => "358451585",
                'email' => "email_cliente@teste.com.br",
            ]
        );
    }

    private function getUser()
    {
        $this->_user = User::updateOrCreate(
            [
                'email' => "email_test@create_2001.com"
            ],
            [
                'id'   => 1,
                'nome' => "Usuario_TDD",
                'email' => "email_test@create_2001.com",
                'password' => bcrypt("123456789"),
                'id_perfil' => $this->_perfil->id,
                'id_cliente' => $this->_cliente->id,
            ]
        );

        $response = $this->call('POST', "/api/login", ['email' => $this->_user['email'], 'password' => '123456789']);
        $this->_token = $response['data']['auth_token'] ?? '';
    }

    private function authUser()
    {
        Sanctum::actingAs($this->_user);
    }

    public function setPermission($perfil, $permission)
    {
        $permissao = Permissao::updateOrCreate(
            ['nome' => $permission],
            ['nome' => $permission]
        );

        PerfilPermissao::updateOrCreate(
            ['id_perfil' => $perfil, 'id_permissao' => $permissao->id],
            ['id_perfil' => $perfil, 'id_permissao' => $permissao->id]
        );
    }

    public function getToken() :array
    {
        return ['Authorization' => 'Bearer '.$this->_token];
    }
}