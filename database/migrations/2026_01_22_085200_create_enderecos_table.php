<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->string('cep', 10);
            $table->string('uf', 30);
            $table->string('cidade', 50);
            $table->string('bairro', 50)->nullable();
            $table->string('logradouro', 100);
            $table->string('numero', 10)->nullable();
            $table->string('nome', 100);
            $table->string('telefone', 15)->nullable();
            $table->string('email', 150)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
