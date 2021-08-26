<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    function store() {
        Book::create($this->validateRequest());
    }

    function update(Book $book) {
        $book->update($this->validateRequest());
    }

    /**
     * @return array
     */
    public function validateRequest(): array
    {
        return request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
    }
}
