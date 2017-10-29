<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class KingTest extends TestCase
{
    /**
     * A basic test for profiles route.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get("/king/");
        $response->assertStatus(Response::HTTP_OK);
    }
}
