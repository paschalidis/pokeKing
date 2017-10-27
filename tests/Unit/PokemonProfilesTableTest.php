<?php

namespace Tests\Unit;

use App\Library\Database\PokemonProfilesContract;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

class PokemonProfilesTableTest extends TestCase
{
    use RefreshDatabase;

    protected $pokemonId = 1;
    protected $pokemonName = "bulbasaur";
    protected $pokemonHeight = 7;
    protected $pokemonWeight = 69;
    protected $pokemonBaseExp = 64;
    protected $pokemonImage = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png";
    protected $pokemonAttributes = array(
        "order" => 1,
        "forms" => array("test" => 1),
        "is_default" => true
    );

    /**
     * Insert Pokemon Data to Database.
     *
     * @return void
     */
    public function testInsert()
    {
        $inserted = $this->insertData();

        $this->assertTrue($inserted);

        $pokemonData = array(
            PokemonProfilesContract::COLUMN_NAME => $this->pokemonName,
        );

        $this->assertDatabaseHas(PokemonProfilesContract::TABLE_NAME, $pokemonData);
    }

    /**
     * Update existing Pokemon Profile.
     *
     * @return void
     */
    public function testUpdate()
    {
        $inserted = $this->insertData();

        $this->assertTrue($inserted);

        $pokemonImage = "https://raw.githubuserco…ites/pokemon/back/1.png";

        $pokemonData = array(
            PokemonProfilesContract::COLUMN_IMAGE => $pokemonImage
        );

        $updated = DB::table(PokemonProfilesContract::TABLE_NAME)
            ->where(PokemonProfilesContract::COLUMN_NAME, $this->pokemonName)
            ->update($pokemonData);

        $this->assertEquals(1, $updated, "Rows Updated");
        $this->assertDatabaseHas(PokemonProfilesContract::TABLE_NAME, $pokemonData);
    }

    /**
     * Delete existing Pokemon.
     *
     * @return void
     */
    public function testDelete()
    {
        $inserted = $this->insertData();
        $this->assertTrue($inserted);

        $deleted = DB::table(PokemonProfilesContract::TABLE_NAME)
            ->where(PokemonProfilesContract::COLUMN_NAME, $this->pokemonName)
            ->delete();

        $this->assertEquals(1, $deleted, "Rows Deleted");
        $this->assertDatabaseMissing(PokemonProfilesContract::TABLE_NAME,
            [PokemonProfilesContract::COLUMN_NAME => $this->pokemonName]);
    }

    /**
     * Insert data to table
     *
     * @return bool
     */
    protected function insertData()
    {
        $pokemonData = array(
            PokemonProfilesContract::COLUMN_ID => $this->pokemonId,
            PokemonProfilesContract::COLUMN_NAME => $this->pokemonName,
            PokemonProfilesContract::COLUMN_IMAGE => $this->pokemonImage,
            PokemonProfilesContract::COLUMN_WEIGHT => $this->pokemonWeight,
            PokemonProfilesContract::COLUMN_HEIGHT => $this->pokemonHeight,
            PokemonProfilesContract::COLUMN_BASE_EXPERIENCE => $this->pokemonBaseExp,
            PokemonProfilesContract::COLUMN_ATTRIBUTES => json_encode($this->pokemonAttributes)
        );

        $inserted = DB::table(PokemonProfilesContract::TABLE_NAME)->insert($pokemonData);

        return $inserted;
    }
}
