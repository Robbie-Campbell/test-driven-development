<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    public function test_a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('api/books', [
            'title' => 'test',
            'author' => 'rab'
        ]);
        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    public function test_a_title_is_required() {
        $response = $this->post('api/books', [
            'title' => '',
            'author' => 'rab'
        ]);
        $response->assertSessionHasErrors('title');
    }

    public function test_an_author_is_required() {
        $response = $this->post('api/books', [
            'title' => 'test',
            'author' => ''
        ]);
        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_updated() {
        $this->withoutExceptionHandling();
        $this->post('api/books', [
            'title' => 'test',
            'author' => 'rab'
        ]);

        $book = Book::first();

        $this->patch('api/books/' . $book->id,[
           'title' => 'new title',
           'author' => 'kelly'
        ]);

        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals('kelly', Book::first()->author);
    }
}
