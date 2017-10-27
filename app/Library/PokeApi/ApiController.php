<?php
/**
 * Created by PhpStorm.
 * User: Pavlos
 * Date: 10/27/2017
 * Time: 6:23 PM
 */

namespace App\Library\PokeApi;

use Illuminate\Http\Response;

class ApiController
{

    /**
     * Recursive function to handle pokemons
     *
     * @param $endpoint
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function getPokemonList($endpoint, $offset = 0, $limit = 200)
    {
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

        $next = $response[PokeApiUtilities::RESPONSE_POKEMON_NEXT];
        if(is_null($next)){
            return $data;
        }

        return array_merge($data, $this->getPokemonList($endpoint, $offset + $limit, $limit));
    }
}