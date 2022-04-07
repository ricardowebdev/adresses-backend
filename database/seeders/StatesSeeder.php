<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            ['sigla' => "AC"],
            ['sigla' => "AL"],
            ['sigla' => "AP"],
            ['sigla' => "AM"],
            ['sigla' => "BA"],
            ['sigla' => "CE"],
            ['sigla' => "ES"],
            ['sigla' => "GO"],
            ['sigla' => "MA"],
            ['sigla' => "MT"],
            ['sigla' => "MS"],
            ['sigla' => "MG"],
            ['sigla' => "PA"],
            ['sigla' => "PB"],
            ['sigla' => "PR"],
            ['sigla' => "PE"],
            ['sigla' => "PI"],
            ['sigla' => "RJ"],
            ['sigla' => "RN"],
            ['sigla' => "RS"],
            ['sigla' => "RO"],
            ['sigla' => "RR"],
            ['sigla' => "SC"],
            ['sigla' => "SP"],
            ['sigla' => "SE"],
            ['sigla' => "TO"],
            ['sigla' => "DF"]            
        ]);
    }
}
