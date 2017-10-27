<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class HunterTest extends TestCase
{
    /**
     * A basic test for hunter route.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get("/hunter/");
        $response->assertStatus(Response::HTTP_OK);
    }
}
