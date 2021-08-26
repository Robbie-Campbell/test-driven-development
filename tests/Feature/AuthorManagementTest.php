<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_author_can_be_created() {
        $this->post('api/author', [
            'name' => 'rab',
            'dob' => '09/10/1995'
        ]);

        $author = Author::first();

        $this->assertCount(1, Author::all());
        $this->assertInstanceOf(Carbon::class, $author->dob);
        $this->assertEquals('1995/10/09', $author->dob->format('Y/d/m'));
    }
}
