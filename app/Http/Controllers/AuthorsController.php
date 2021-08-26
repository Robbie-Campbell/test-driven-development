<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store() {
        $post = request()->validate([
            'name' => 'required',
            'dob' => 'required',
        ]);
        Author::create($post);
    }
}
