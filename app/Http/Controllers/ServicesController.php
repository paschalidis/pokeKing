<?php

namespace App\Http\Controllers;

use App\Library\Database\PokemonsContract;
use App\Library\PokeApi\ApiController;
use App\Library\PokeApi\PokeApiUtilities;
use Illuminate\Http\Request;
use DB;
use Mockery\Exception;

class ServicesController extends Controller
{
    /*
     * Function to get and store all pokemon from pokemon API
     */
    public function pokemonHunter()
    {
        echo "Pokemon Hunter.<br>";

        $apiController = new ApiController();

        $endpoint = PokeApiUtilities::API_BASE_URL . PokeApiUtilities::ENDPOINT_POKEMON;
        $pokemons = $apiController->getPokemonList($endpoint);

        if(empty($pokemons)){
            echo "No Pokemons found";
            return;
        }

        $totalAdded = 0;
        $totalRejected = 0;
        foreach ($pokemons as $pokemon){

            $dataToInsert = array(
                PokemonsContract::COLUMN_NAME => $pokemon[PokeApiUtilities::POKEMON_ENTITY_NAME],
                PokemonsContract::COLUMN_URL => $pokemon[PokeApiUtilities::POKEMON_ENTITY_URL]
            );

            try{
                $inserted = DB::table(PokemonsContract::TABLE_NAME)->insert($dataToInsert);
            } catch (\Illuminate\Database\QueryException $e){
                $inserted = false;
            }

            if($inserted){
                $totalAdded ++;
            } else {
                $totalRejected ++;
            }
        }

        echo "Total Pokemons inserted: " . $totalAdded;
        echo "<br>";
        echo "Total Pokemons rejected: " . $totalRejected;
    }
}
