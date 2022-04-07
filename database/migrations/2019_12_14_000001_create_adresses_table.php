<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->string('cep', 10);
            $table->string('estado', 2);
            $table->string('cidade', 50);
            $table->string('bairro', 50);
            $table->string('endereco', 255);
            $table->string('numero', 10);
            $table->string('nome_contato', 50);
            $table->string('email_contato', 100);
            $table->string('telefone_contato', 15);
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adresses');
    }
}
