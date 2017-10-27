<?php

namespace App\Jobs;

use App\Library\Database\PokemonsContract;
use App\Library\PokeApi\ApiController;
use App\Library\PokeApi\PokeApiUtilities;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

class PokemonHunterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    protected $_attempts;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_attempts = 0;
    }

    /**
     * Execute the job.
     *
     *  Function to get and store all pokemon from pokemon API
     *
     * @return void
     */
    public function handle()
    {
        $this->_attempts ++;

        if($this->_attempts > $this->tries){
            return;
        }
        echo "Pokemon Hunter Start.\n";

        $apiController = new ApiController();

        $pokemons = $apiController->getPokemonList();

        if(empty($pokemons)){
            echo "No Pokemons found: Retry\n";
            $this->handle();
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
        echo "\n";
        echo "Total Pokemons rejected: " . $totalRejected;
        echo "\n";

        //Check if total pokemons in db are same with pokemons count from api
        $pokemonsInDB = DB::table(PokemonsContract::TABLE_NAME)->count();
        if($pokemonsInDB == $apiController->totalPokemons){
            echo "All pokemons are stored to database\n";
        } else {
            echo "More pokemon Go Hunt: Retry\n";
            $this->handle();
            return;
        }
    }
}
