<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PokemonController extends Controller
{
    //
    public function pokemonList()
    {
        return view('list', ["name" => "Makis"]);
    }
}
