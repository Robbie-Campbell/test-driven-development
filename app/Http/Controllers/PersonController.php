<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index() {
        return Person::all();
    }

    public function store(Request $request)
    {
        $person = new Person;
        $person->name = $request->name;
        $person->age = $request->age;
        $person->save();
        return [
            "created" => true
        ];
    }

    public function show($id)
    {
        $person = Person::findOrFail($id);
        return $person;
    }

    public function update(Request $request, $id)
    {
        $person = Person::find($id);
        $person->name = $request->name;
        $person->age = $request->age;
        $person->save();
        return $person;
    }

    public function destroy($id)
    {
        return Person::destroy($id);
    }
}
