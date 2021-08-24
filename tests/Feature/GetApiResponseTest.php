<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetApiResponseTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_post_person_to_db() {
        testcase::factory(Person::class)->create();
        $response = $this->postJson('api/person', [
            "name" => "robbie",
            "age" => 25
        ]);

        $response->assertStatus(200)->assertJson([
            "created" => true
        ]);
    }

    public function test_get_person_from_db() {
        $response = $this->get('/api/person/1');
        $response->assertJson([
            "name" => "robbie",
            "age" => 25
        ], $response->content());
    }

    public function test_update_person_in_db() {
        $response = $this->put("/api/person/1", [
            "name" => "kelly",
            "age" => 24
        ]);

        $response->assertStatus(200);

        $this->get("api/person/1")->assertJson([
            "name"=> "kelly",
            "age" => 24
        ]);
    }

//    public function test_delete_person_from_db() {
//        $response = $this->delete('api/person/1');
//        $this->assertEquals(200, $response->getStatusCode());
//    }
}
