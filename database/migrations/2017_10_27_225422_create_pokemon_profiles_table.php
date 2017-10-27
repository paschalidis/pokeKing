<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Library\Database\PokemonProfilesContract;

class CreatePokemonProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(PokemonProfilesContract::TABLE_NAME, function (Blueprint $table) {
            $table->integer(PokemonProfilesContract::COLUMN_ID);
            $table->string(PokemonProfilesContract::COLUMN_NAME);
            $table->string(PokemonProfilesContract::COLUMN_IMAGE);
            $table->integer(PokemonProfilesContract::COLUMN_HEIGHT);
            $table->integer(PokemonProfilesContract::COLUMN_WEIGHT);
            $table->integer(PokemonProfilesContract::COLUMN_BASE_EXPERIENCE);
            $table->json(PokemonProfilesContract::COLUMN_ATTRIBUTES);

            $table->timestamp(PokemonProfilesContract::COLUMN_CREATED_AT)
                ->default(DB::raw("CURRENT_TIMESTAMP"));

            $table->timestamp(PokemonProfilesContract::COLUMN_UPDATED_AT)->nullable();

            $table->unique(PokemonProfilesContract::COLUMN_NAME);

            $table->primary(PokemonProfilesContract::COLUMN_ID);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(PokemonProfilesContract::TABLE_NAME);
    }
}
