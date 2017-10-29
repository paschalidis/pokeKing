<?php

namespace Tests\Feature;


use Illuminate\Http\Response;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    /**
     * A basic test for profiles route.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get("/profiles/");
        $response->assertStatus(Response::HTTP_OK);
    }
}
