<?php

namespace App\Http\Controllers;

use App\Jobs\PokemonHunterJob;
use App\Jobs\PokemonProfile;
use App\Library\Database\PokemonsContract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class ServicesController extends Controller
{
    /*
     * Action to start Pokemon Hunter Job
     */
    public function pokemonHunter()
    {
        PokemonHunterJob::dispatch();
    }

    /*
    * Action to start Pokemon Profile Jobs
     *
     * Get all pokemons to check and send to jobs per 50 urls
    */
    public function pokemonProfiles()
    {
        $pokemonsToCheck = DB::table(PokemonsContract::TABLE_NAME)
            ->select(PokemonsContract::COLUMN_URL)
            ->whereNull(PokemonsContract::COLUMN_UPDATED_AT)
            ->get();

        $pokemonsToCheckArray = $pokemonsToCheck->toArray();
        $pokemonsToCheckArray = array_chunk($pokemonsToCheckArray, 50);

        foreach ($pokemonsToCheckArray as $pokemonToSend){
            PokemonProfile::dispatch($pokemonToSend)
            ->delay(Carbon::now()->addMinutes(1));
        }
    }

}
