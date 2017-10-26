<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use \App\Library\Database\PokemonsContract;
use Illuminate\Support\Facades\DB;

class CreatePokemonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(PokemonsContract::TABLE_NAME, function (Blueprint $table) {
            $table->increments(PokemonsContract::COLUMN_ID);
            $table->string(PokemonsContract::COLUMN_NAME, 20);
            $table->string(PokemonsContract::COLUMN_URL, 100);

            $table->timestamp(PokemonsContract::COLUMN_CREATED_AT)
                ->default(DB::raw("CURRENT_TIMESTAMP"));

            $table->timestamp(PokemonsContract::COLUMN_UPDATED_AT)->nullable();

            $table->unique(PokemonsContract::COLUMN_NAME);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(PokemonsContract::TABLE_NAME);
    }
}
