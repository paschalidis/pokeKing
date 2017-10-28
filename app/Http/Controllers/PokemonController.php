<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PokemonController extends Controller
{
    //
    public function pokemonList()
    {
        $pokemons = array(1,2,3);
        return view('list', ["pokemons" => $pokemons]);
    }
}
