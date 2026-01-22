<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Chave;
use App\Repositories\ChaveRepository;
use Tests\Traits\CreateData;

class ChaveTest extends TestCase
{
    use CreateData;
    protected $_chave;
    protected $_request;

    public function setUp() :void
    {
        parent::setUp();
        self::createUserAuthData();  
        self::authUser();
        $this->produzChave();
    }

    public function test_list_of_keys(): void
    {        
        $this->setPermission($this->_user->id_perfil, 'listar_chaves');
        $response = $this->call('GET', '/api/chaves', [], [], [], $this->getToken());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_show_key() :void
    {
        $id = (string) $this->_chave->id;
        $this->setPermission($this->_user->id_perfil, 'listar_chaves');
        
        $response = $this->call('GET', '/api/chaves/'.$id, [], [], [], $this->getToken());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_show_key_invalid() :void
    {
        $this->setPermission($this->_user->id_perfil, 'listar_chaves');
        $response = $this->call('GET', '/api/chaves/999999', [], [], [], $this->getToken());
        $this->assertEquals(400, $response->getStatusCode());
    }


    public function test_store_key() :void
    {
        $this->setPermission($this->_user->id_perfil, 'criar_chaves');
        $response = $this->call('POST', "/api/chaves/", $this->_request, [], [], $this->getToken());

        $this->assertEquals(201, $response->getStatusCode());
        $this->_chave = Chave::where('appkey', '=', $this->_request['appkey'])->get()->first();
        $this->assertEquals($this->_request['appkey'], $this->_chave->appkey);
    }

    public function test_edit_key() :void
    {
        $this->_request['appkey'] = 'key_edit '.rand(0, 999);
        $id = (string) $this->_chave->id;
        $this->_request['id'] = $id;
        
        $this->setPermission($this->_user->id_perfil, 'editar_chaves');
        $response = $this->call('put', "/api/chaves/".$id, $this->_request, [], [], $this->getToken());

        $this->assertEquals(200, $response->getStatusCode());
        $this->_chave = app(ChaveRepository::class)->exibeChave($this->_chave->id);
        $this->assertEquals($this->_request['appkey'], $this->_chave->appkey);
    }

    public function test_destroy_key() :void
    {
        $this->setPermission($this->_user->id_perfil, 'remover_chaves');
        $response = $this->call('delete', "/api/chaves/".$this->_chave->id, [], [], [], $this->getToken());
        $this->assertEquals(200, $response->getStatusCode());
        $this->_chave = Chave::find($this->_chave->id);
        $this->assertNull($this->_chave);
    }

    private function produzChave()
    {        
        $this->_request = [
            'id'         => rand(1, 10000)."23".rand(1, 10000),
            'id_cliente' => $this->_cliente->id,
            'name'       => "Chave teste ".rand(1, 10000),
            'deveui'     => "serial".rand(1, 10000),
            'appeui'     => "appeui".rand(1, 10000),
            'appkey'     => "key".rand(1, 10000),
            'lat'        => "1855464856",
            'lng'        => "1855464856",
        ];

        $this->_chave = Chave::get()->first();
        if (empty($this->_chave->id)) {
            $this->_chave = Chave::create($this->_request);
        }
    }
}
