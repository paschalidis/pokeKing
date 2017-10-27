<?php

/*
 * Here are stored all hardcoded string to use https://pokeapi.co/
 * Interface
 */

namespace App\Library\PokeApi;

interface PokeApiUtilities
{
    const API_BASE_URL = "http://pokeapi.co/api/v2/";

    const ENDPOINT_POKEMON = "pokemon/";

    const RESPONSE_POKEMON_COUNT = "count";
    const RESPONSE_POKEMON_RESULTS = "results";
    const RESPONSE_POKEMON_NEXT = "next";
    const RESPONSE_POKEMON_PREVIOUS = "previous";

    const PARAM_OFFSET = "offset";
    const PARAM_LIMIT = "limit";

    const POKEMON_ENTITY_URL = "url";
    const POKEMON_ENTITY_NAME = "name";
}

