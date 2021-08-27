<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

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
        $response->assertSessionHasErrors('author_id');
    }

    public function test_a_book_can_be_updated() {
        $this->createANewBook('test', 'rab');
        $book = Book::first();
        $response = $this->patch($book->path(),[
           'title' => 'new title',
           'author_id' => 'kelly'
        ]);
        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals(DB::getPdo()->lastInsertId(), Book::first()->author_id);
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

    public function test_a_new_author_is_automatically_added() {
        $this->createANewBook('test', 'rab');

        $book = Book::first();
        $author = Author::first();

        $this->assertCount(1, Author::all());
        $this->assertEquals($author->id, $book->author_id);
    }

    public function createANewBook($title, $author)
    {
        return $this->post('api/books', [
            'title' => $title,
            'author_id' => $author
        ]);
    }
}
