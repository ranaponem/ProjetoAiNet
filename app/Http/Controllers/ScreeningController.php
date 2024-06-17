<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Screening;
use App\Models\Theater;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScreeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $movieId = $request->movie;
        $movie = Movie::find($movieId);

        if (!$movie) {
            abort(404, 'Movie not found');
        }


        $screenings = Screening::where('movie_id', $movieId)->get();
        $theaters = Theater::all();

        // Eager load related models for better performance
        $screenings->load('theater', 'tickets');

        return view('screenings.index', compact('screenings', 'movie', 'theaters'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $movie = Movie::find($request->movie);
        $theaters = Theater::all();

        return view('screenings.create', compact('movie', 'theaters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

        $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->start_time);

        Screening::create([
            'movie_id' => $request->movie_id,
            'theater_id' => $request->theater_id,
            'date' => $startDateTime->format('Y-m-d'),
            'start_time' => $startDateTime->format('H:i:s'),
            // Add more fields as needed
        ]);

        return redirect()->route('screenings.index', ['movie' => $request->movie_id])
            ->with('success', 'Screening created successfully.');
    }

    public function show(string $id)
    {
        // Retrieve the screening by its ID and load related movie, theater, and tickets
        $screening = Screening::with(['movie', 'theater', 'tickets'])->findOrFail($id);
        $tickets = $screening->tickets;

        // Return the view with the screening data
        return view('screenings.show', compact('screening','tickets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $screening = Screening::with('theater')->findOrFail($id);
            $theaters = Theater::all();
            return view('screenings.edit', compact('screening', 'theaters'));
        } catch (\Exception $e) {
            return redirect()->route('screenings.index')->with('error', 'Screening not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Screening $screening)
    {
        $validatedData = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

        $screening->update([
            'movie_id' => $validatedData['movie_id'],
            'theater_id' => $validatedData['theater_id'],
            'date' => $validatedData['date'],
            'start_time' => $validatedData['start_time'],
        ]);

        $movie = Movie::find($validatedData['movie_id']);

        return redirect()->route('screenings.index',compact('movie'))
            ->with('success', 'Screening updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screening $screening)
    {
        try {
            $screening->delete();
            return redirect()->route('screenings.index', ['movie' => $screening->movie_id])
                ->with('success', 'Screening deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('screenings.index', ['movie' => $screening->movie_id])
                ->with('error', 'Screening not found.');
        }
    }

}
