<?php

namespace App\Http\Controllers;

use App\Jobs\PokemonHunterJob;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /*
     * Action to start Pokemon Hunter Job
     */
    public function pokemonHunter()
    {
        PokemonHunterJob::dispatch();
    }
}
