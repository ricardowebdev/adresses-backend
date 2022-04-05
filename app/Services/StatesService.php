<?php

namespace App\Services;

use App\Models\States;

class StatesService
{
    public function list()
    {
        $states = States::get();
        return $states;
    }
}
