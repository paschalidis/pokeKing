<?php

/*
 * Here are stored all hardcoded string for Database usages
 * Interfaces with tables names that contains constants
 * values for table name and columns names
 */

namespace App\Library\Database;

interface PokemonsContract
{
    const TABLE_NAME = "pokemons";

    const COLUMN_ID = "id";
    const COLUMN_NAME = "name";
    const COLUMN_URL = "url";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_UPDATED_AT = "updated_at";
}

