<?php

namespace App\Jobs;

use App\Library\Database\PokemonProfilesContract;
use App\Library\Database\PokemonsContract;
use App\Library\PokeApi\ApiController;
use App\Library\PokeApi\PokeApiUtilities;
use Illuminate\Bus\Queueable;
use Illuminate\Database\QueryException;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

class PokemonProfile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pokemonsToCheck;
    protected $totalInserted;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pokemonsTocheck)
    {
        $this->pokemonsToCheck = $pokemonsTocheck;
        $this->totalInserted = 0;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo "Pokemon Profile Start.\n";
        $apiController = new ApiController();
        foreach ($this->pokemonsToCheck as $pokemon){
            $pokemonProfile = $apiController->getPokemonProfile($pokemon->url);
            $this->checkAndSaveProfile($pokemonProfile);
        }
        echo "Total Inserted: " . $this->totalInserted . "\n";
        echo "Pokemon Profile End.\n";
    }

    /**
     * Check the profile if have criteria to pass and then saved it
     *
     * To save pokemon profile must have height >= 50 and
     * sprites->front_default exists
     *
     * @param $profileData
     */
    protected function checkAndSaveProfile($profileData)
    {
        if(empty($profileData)){
            return;
        }

        $pokemonProfileName = $profileData[PokeApiUtilities::RESPONSE_PROFILE_NAME];

        //Set updated time to not check again for this pokemon
        try{
            DB::table(PokemonsContract::TABLE_NAME)
                ->where(PokemonsContract::COLUMN_NAME, $pokemonProfileName)
                ->update([PokemonsContract::COLUMN_UPDATED_AT => Date("Y/m/d H:i:s", time())]);
        } catch (QueryException $e){
            echo $e . "\n";
        }

        $pokemonProfileHeight = $profileData[PokeApiUtilities::RESPONSE_PROFILE_HEIGHT];
        if($pokemonProfileHeight < 50){
            return;
        }

        $pokemonProfileSprites = $profileData[PokeApiUtilities::RESPONSE_PROFILE_SPRITES];

        if (!isset($pokemonProfileSprites[PokeApiUtilities::RESPONSE_PROFILE_SPRITES_FRONT_DEFAULT])) {
            return;
        }

        if(empty($pokemonProfileSprites[PokeApiUtilities::RESPONSE_PROFILE_SPRITES_FRONT_DEFAULT])){
            return;
        }

        $pokemonProfileImage = $pokemonProfileSprites[PokeApiUtilities::RESPONSE_PROFILE_SPRITES_FRONT_DEFAULT];

        /**
         * Bind data
         */
        $pokemonProfileForms = $profileData[PokeApiUtilities::RESPONSE_PROFILE_FORMS];
        $pokemonProfileAbilities = $profileData[PokeApiUtilities::RESPONSE_PROFILE_ABILITIES];
        $pokemonProfileStats = $profileData[PokeApiUtilities::RESPONSE_PROFILE_STATS];
        $pokemonProfileWeight = $profileData[PokeApiUtilities::RESPONSE_PROFILE_WEIGHT];
        $pokemonProfileMoves = $profileData[PokeApiUtilities::RESPONSE_PROFILE_MOVES];
        $pokemonProfileHeldItems = $profileData[PokeApiUtilities::RESPONSE_PROFILE_HELD_ITEMS];
        $pokemonProfileLocationAreaEnc = $profileData[PokeApiUtilities::RESPONSE_PROFILE_LOCATION_AREA_ENCOUNTERS];
        $pokemonProfileIsDefault = $profileData[PokeApiUtilities::RESPONSE_PROFILE_IS_DEFAULT];
        $pokemonProfileSpecies = $profileData[PokeApiUtilities::RESPONSE_PROFILE_SPECIES];
        $pokemonProfileId = $profileData[PokeApiUtilities::RESPONSE_PROFILE_ID];
        $pokemonProfileOrder = $profileData[PokeApiUtilities::RESPONSE_PROFILE_ORDER];
        $pokemonProfileGameIndices = $profileData[PokeApiUtilities::RESPONSE_PROFILE_GAME_INDICES];
        $pokemonProfileBaseExp = $profileData[PokeApiUtilities::RESPONSE_PROFILE_BASE_EXPERIENCE];
        $pokemonProfileTypes = $profileData[PokeApiUtilities::RESPONSE_PROFILE_TYPES];

        $pokemonProfileAttributes = array(
            $pokemonProfileForms,
            $pokemonProfileAbilities,
            $pokemonProfileStats,
            $pokemonProfileMoves,
            $pokemonProfileHeldItems,
            $pokemonProfileLocationAreaEnc,
            $pokemonProfileIsDefault,
            $pokemonProfileSpecies,
            $pokemonProfileOrder,
            $pokemonProfileGameIndices,
            $pokemonProfileTypes,
            $pokemonProfileSprites
        );

        $dataToInsert = array(
            PokemonProfilesContract::COLUMN_ID => $pokemonProfileId,
            PokemonProfilesContract::COLUMN_NAME => $pokemonProfileName,
            PokemonProfilesContract::COLUMN_IMAGE => $pokemonProfileImage,
            PokemonProfilesContract::COLUMN_HEIGHT => $pokemonProfileHeight,
            PokemonProfilesContract::COLUMN_WEIGHT => $pokemonProfileWeight,
            PokemonProfilesContract::COLUMN_BASE_EXPERIENCE => $pokemonProfileBaseExp,
            PokemonProfilesContract::COLUMN_ATTRIBUTES => json_encode($pokemonProfileAttributes)
        );

        try{
            $inserted = DB::table(PokemonProfilesContract::TABLE_NAME)->insert($dataToInsert);
        } catch (QueryException $e){
            echo $e . "\n";
            $inserted = false;
        }

        if($inserted){
            $this->totalInserted ++;
        } else {
            // Set it to null to retry next time
            try{
                DB::table(PokemonsContract::TABLE_NAME)
                    ->where(PokemonsContract::COLUMN_NAME, $pokemonProfileName)
                    ->update([PokemonsContract::COLUMN_UPDATED_AT => null]);
            } catch (QueryException $e){
                echo $e . "\n";
            }
        }
    }
}
