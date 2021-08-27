<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** test */
class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_name_is_required_to_create_an_author() {
        Author::firstOrCreate([
            'name' => 'John Doe'
        ]);

        $this->assertCount(1, Author::all());
    }
}
