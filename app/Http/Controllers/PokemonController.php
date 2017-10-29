<?php

namespace App\Http\Controllers;

use App\Library\Database\PokemonProfilesContract;
use App\Models\Pokemon;
use Illuminate\Http\Request;


class PokemonController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pokemonList()
    {
        $selectColumns = array(
            PokemonProfilesContract::COLUMN_NAME,
            PokemonProfilesContract::COLUMN_WEIGHT,
            PokemonProfilesContract::COLUMN_IMAGE,
            PokemonProfilesContract::COLUMN_HEIGHT,
            PokemonProfilesContract::COLUMN_BASE_EXPERIENCE
        );
        $pokemons = Pokemon::orderBy(PokemonProfilesContract::COLUMN_WEIGHT, 'desc')
            ->get($selectColumns);

        return view('list', ["pokemons" => $pokemons]);
    }

    public function pokemonKing()
    {
        echo "Pokemon King";
    }
}
