<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Carbon\Carbon;
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
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre->name = $request->name;
        $genre->save();

        return redirect()->route('genres.index')->with('success', 'Genre updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $startDate = Carbon::today();
        $endDate = $startDate->copy()->addWeeks(2);
        foreach($genre->movies as $movie){
            if($this->getScreeningsForDateRange($movie, $startDate, $endDate)->count() !== 0){
                return redirect()->route('genres.index');
            }
        }

        $genre->delete();

        return redirect()->route('genres.index');
    }

    private function getScreeningsForDateRange(Movie $movie, Carbon $startDate, Carbon $endDate)
    {
        $now = Carbon::now();
        $fiveMinutesAgo = $now->copy()->subMinutes(5);

        return $movie->screenings()
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', start_time), '%Y-%m-%d %H:%i:%s') >= ?", [$fiveMinutesAgo])
            ->get();
    }
}
