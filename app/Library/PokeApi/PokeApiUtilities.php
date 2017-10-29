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

    /**
     * Response Pokemon
     */
    const RESPONSE_POKEMON_COUNT = "count";
    const RESPONSE_POKEMON_RESULTS = "results";
    const RESPONSE_POKEMON_NEXT = "next";
    const RESPONSE_POKEMON_PREVIOUS = "previous";

    const PARAM_OFFSET = "offset";
    const PARAM_LIMIT = "limit";

    /**
     * Response Profile
     */
    const RESPONSE_PROFILE_FORMS = "forms";
    const RESPONSE_PROFILE_ABILITIES = "abilities";
    const RESPONSE_PROFILE_STATS = "stats";
    const RESPONSE_PROFILE_NAME = "name";
    const RESPONSE_PROFILE_WEIGHT = "weight";
    const RESPONSE_PROFILE_MOVES = "moves";
    const RESPONSE_PROFILE_SPRITES = "sprites";
    const RESPONSE_PROFILE_SPRITES_FRONT_DEFAULT = "front_default";
    const RESPONSE_PROFILE_HELD_ITEMS = "held_items";
    const RESPONSE_PROFILE_LOCATION_AREA_ENCOUNTERS = "location_area_encounters";
    const RESPONSE_PROFILE_HEIGHT = "height";
    const RESPONSE_PROFILE_IS_DEFAULT = "is_default";
    const RESPONSE_PROFILE_SPECIES = "species";
    const RESPONSE_PROFILE_ID = "id";
    const RESPONSE_PROFILE_ORDER = "order";
    const RESPONSE_PROFILE_GAME_INDICES = "game_indices";
    const RESPONSE_PROFILE_BASE_EXPERIENCE = "base_experience";
    const RESPONSE_PROFILE_TYPES = "types";


    /**
     * Entities
     */
    const POKEMON_ENTITY_URL = "url";
    const POKEMON_ENTITY_NAME = "name";
}