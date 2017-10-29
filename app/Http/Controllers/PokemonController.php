<?php

namespace App\Http\Controllers;

use App\Library\Database\PokemonProfilesContract;
use App\Models\Pokemon;
use Illuminate\Http\Request;
use DB;


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

    /**
     * Function to calculate the pokeKing pokemon
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pokemonKing()
    {
        $rawSelect = PokemonProfilesContract::COLUMN_IMAGE . "," . PokemonProfilesContract::COLUMN_NAME;
        $rawSelect .= ", JSON_EXTRACT(" . PokemonProfilesContract::COLUMN_ATTRIBUTES . ", '$**." . PokemonProfilesContract::COLUMN_ATTRIBUTES_BASE_STAT . "') AS base_stats";

        $pokemons = DB::table(PokemonProfilesContract::TABLE_NAME)
            ->select(DB::raw($rawSelect))
            ->get();

        $pokeKing = array();
        $maxBaseStats = 0;
        foreach ($pokemons as $pokemon){

            $baseStatsSum = array_sum(json_decode($pokemon->base_stats, true));
            if($baseStatsSum > $maxBaseStats){
                $pokeKing = array(
                    PokemonProfilesContract::COLUMN_IMAGE => $pokemon->image,
                    PokemonProfilesContract::COLUMN_NAME => $pokemon->name,
                    "stats" => $baseStatsSum
                );
                $maxBaseStats = $baseStatsSum;
            }
        }

        return response()->json($pokeKing);
    }
}
