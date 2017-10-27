<?php

namespace Tests\Unit;

use App\Library\Database\PokemonsContract;
use Mockery\Exception;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

/**
 * Class PokemonTableTest
 *
 * Testing pokemons database table CRUD actions
 *
 * @package Tests\Unit
 */
class PokemonTableTest extends TestCase
{
    use RefreshDatabase;

    protected $pokemonName = "bulbasaur";
    protected $pokemonUrl = "https://pokeapi.co/api/v2/pokemon/1/";

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
            PokemonsContract::COLUMN_NAME => $this->pokemonName,
            PokemonsContract::COLUMN_URL => $this->pokemonUrl
        );

        $this->assertDatabaseHas(PokemonsContract::TABLE_NAME, $pokemonData);
    }

    /**
     * Update existing Pokemon.
     *
     * @return void
     */
    public function testUpdate()
    {
        $inserted = $this->insertData();

        $this->assertTrue($inserted);

        $pokemonUrl = "https://pokeapi.co/api/v2/pokemon/2/";

        $pokemonData = array(
            PokemonsContract::COLUMN_URL => $pokemonUrl
        );

        $updated = DB::table(PokemonsContract::TABLE_NAME)
            ->where(PokemonsContract::COLUMN_NAME, $this->pokemonName)
            ->update($pokemonData);

        $this->assertEquals(1, $updated, "Rows Updated");
        $this->assertDatabaseHas(PokemonsContract::TABLE_NAME, $pokemonData);
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

        $deleted = DB::table(PokemonsContract::TABLE_NAME)
            ->where(PokemonsContract::COLUMN_NAME, $this->pokemonName)
            ->delete();

        $this->assertEquals(1, $deleted, "Rows Deleted");
        $this->assertDatabaseMissing(PokemonsContract::TABLE_NAME, [PokemonsContract::COLUMN_NAME => $this->pokemonName]);
    }

    /**
     * Insert multiple Pokemons.
     *
     * @return void
     */
    public function testMassiveInsert()
    {
        $pokemon1 = array(
            PokemonsContract::COLUMN_NAME => $this->pokemonName,
            PokemonsContract::COLUMN_URL => $this->pokemonUrl
        );

        $pokemon2 = array(
            PokemonsContract::COLUMN_NAME => "test",
            PokemonsContract::COLUMN_URL => "https:www/pokemon/test"
        );

        $inserted = DB::table(PokemonsContract::TABLE_NAME)
            ->insert([$pokemon1, $pokemon2]);

        $this->assertTrue($inserted);
        $this->assertDatabaseHas(PokemonsContract::TABLE_NAME, $pokemon1);
        $this->assertDatabaseHas(PokemonsContract::TABLE_NAME, $pokemon2);
    }

    /**
     * Testing if you can insert pokemon with same name
     *
     * @expectedException Exception
     */
    public function testInsertExistingPokemon()
    {
        $inserted = $this->insertData();
        $this->assertTrue($inserted);

        $inserted = $this->insertData();
        $this->assertFalse($inserted);
    }

    /**
     * Testing if pokemons inserted with massive and same pokemons
     *
     * @expectedException Exception
     */
    public function testInsertMassiveSamePokemon()
    {
        $pokemon1 = array(
            PokemonsContract::COLUMN_NAME => $this->pokemonName,
            PokemonsContract::COLUMN_URL => $this->pokemonUrl
        );

        $pokemon2 = array(
            PokemonsContract::COLUMN_NAME => "test",
            PokemonsContract::COLUMN_URL => "https:www/pokemon/test"
        );

        $pokemon3 = $pokemon1;

        $inserted = DB::table(PokemonsContract::TABLE_NAME)
            ->insert([$pokemon1, $pokemon2, $pokemon3]);

        $this->assertTrue($inserted);
        $this->assertDatabaseHas(PokemonsContract::TABLE_NAME, $pokemon1);
        $this->assertDatabaseHas(PokemonsContract::TABLE_NAME, $pokemon2);
    }

    /**
     * Insert data to table
     *
     * @return bool
     */
    protected function insertData()
    {
        $pokemonData = array(
            PokemonsContract::COLUMN_NAME => $this->pokemonName,
            PokemonsContract::COLUMN_URL => $this->pokemonUrl
        );

        $inserted = DB::table(PokemonsContract::TABLE_NAME)->insert($pokemonData);

        return $inserted;
    }
}
