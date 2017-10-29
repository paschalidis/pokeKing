<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class ListTest extends TestCase
{
    /**
     * A basic test for list pokemon profiles route.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get("/");

        $data = $response->original->getData();

        $this->assertArrayHasKey("pokemons", $data);
        $response->assertStatus(Response::HTTP_OK);
    }
}
