<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Genre::class);
        //return the view with the genres
        $genres= Genre::all();
        return view('genres.index',compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:genres,code',
            'name' => 'required',
        ]);

        // Capitalize the first letter of the name
        $validatedData['name'] = ucfirst($validatedData['name']);


        Genre::create($validatedData);

        return redirect()->route('genres.index')->with('success', 'Genre created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $code)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre = Genre::where('code', $code)->firstOrFail();
        $genre->name = $request->name;
        $genre->save();

        return redirect()->route('genres.index')->with('success', 'Genre updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code)
    {
        $genre = Genre::where('code', $code)->firstOrFail();
        $genre->delete();

        return redirect()->route('genres.index')->with('success', 'Genre deleted successfully.');
    }
}
