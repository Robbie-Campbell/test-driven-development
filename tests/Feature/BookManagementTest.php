<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/** test */
class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    public function test_a_book_can_be_added_to_the_library()
    {
        $response = $this->createANewBook('test', 'rab');
        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    public function test_a_title_is_required() {
        $response = $this->createANewBook('', 'rab');
        $response->assertSessionHasErrors('title');
    }

    public function test_an_author_is_required() {
        $response = $this->createANewBook('test', '');
        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_updated() {
        $this->createANewBook('test', 'rab');
        $book = Book::first();
        $response = $this->patch($book->path(),[
           'title' => 'new title',
           'author' => 'kelly'
        ]);
        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals('kelly', Book::first()->author);
        $response->assertRedirect($book->path());
    }

    public function test_a_book_can_be_deleted() {
        $this->createANewBook('test', 'rab');
        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    public function createANewBook($title, $author)
    {
        return $this->post('api/books', [
            'title' => $title,
            'author' => $author
        ]);
    }
}
