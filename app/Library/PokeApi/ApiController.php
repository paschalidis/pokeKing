<?php

namespace App\Library\PokeApi;

use Illuminate\Http\Response;

class ApiController
{

    /**
     * Tha number of pokemon in pokeapi
     *
     * @var int
     */
    public $totalPokemons = 0;

    /**
     * Recursive function to handle pokemons
     *
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function getPokemonList($offset = 0, $limit = 200)
    {
        $endpoint = PokeApiUtilities::API_BASE_URL . PokeApiUtilities::ENDPOINT_POKEMON;
        $url = $endpoint . "?" . PokeApiUtilities::PARAM_OFFSET . "=" . $offset;
        $url .= "&" . PokeApiUtilities::PARAM_LIMIT . "=" . $limit;

        $ch = curl_init();
        $timeout = 10;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $responseJson = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code != Response::HTTP_OK) {
            return array();
        }

        $response = json_decode($responseJson, true);
        $data = $response[PokeApiUtilities::RESPONSE_POKEMON_RESULTS];
        $this->totalPokemons = $response[PokeApiUtilities::RESPONSE_POKEMON_COUNT];
        $next = $response[PokeApiUtilities::RESPONSE_POKEMON_NEXT];
        if(is_null($next)){
            return $data;
        }

        return array_merge($data, $this->getPokemonList($offset + $limit, $limit));
    }

    /**
     * Function to handle pokemon profile data
     *
     * @param $pokemonEndpoint
     * @return array
     */
    public function getPokemonProfile($pokemonEndpoint)
    {
        $response = array();

        $ch = curl_init();
        $timeout = 10;
        curl_setopt($ch, CURLOPT_URL, $pokemonEndpoint);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $responseJson = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code != Response::HTTP_OK) {
            return $response;
        }

        $response = json_decode($responseJson, true);

        return $response;
    }
}