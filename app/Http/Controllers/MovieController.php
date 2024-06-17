<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): View
    {
        $query = Movie::query();
        $genres = Genre::all();

        if ($request->has('genre_code') && $request->genre_code) {
            $query->where('genre_code', $request->genre_code);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('synopsis', 'like', '%' . $request->search . '%');
            });
        }

        $movies = $query->paginate(15)->withQueryString();

        return view('movies.index',compact('movies', 'genres'));
    }

    public function indexOnShow(Request $request): View
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(15);

        $genres = Genre::all();

        $query = Movie::whereHas('screenings', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        });

        if ($request->has('genre_code') && $request->genre_code) {
            $query->where('genre_code', $request->genre_code);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('synopsis', 'like', '%' . $request->search . '%');
            });
        }

        $moviesOnShow = $query->paginate(15)->withQueryString();

        return view('movies.indexOnShow',compact('moviesOnShow', 'genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $genres=Genre::all();
        $movie=new Movie();
        return view('movies.create',compact('movie','genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'trailer_url' => 'required|url',
            'genre_code' => 'required|string|exists:genres,code|max:20',
            'poster_filename' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max size for image files
            'synopsis' => 'nullable|string',
            'year'=>'required|integer|min:1900|max:2100|digits:4',
        ]);

        // Handle file upload for poster
        if ($request->hasFile('poster_filename')) {
            $posterPath = $request->file('poster_filename')->store('public/posters');
            $photoFilename = basename($posterPath);
        }

        // Create a new movie record
        $movie = new Movie();
        $movie->title = $validatedData['title'];
        $movie->year = $validatedData['year'];
        $movie->trailer_url = $validatedData['trailer_url'];
        $movie->genre_code = $validatedData['genre_code'];
        $movie->synopsis = $validatedData['synopsis'] ?? null;
        $movie->poster_filename = $photoFilename ?? null;
        $movie->save();

        // Redirect back to the index page with success message
        return redirect()->route('movies.index')->with('success', 'Movie created successfully!');
    }

    /**
     * Display the specified resource.
     */


    public function show(int $movieId, Request $request): View
    {
        // Retrieve the movie by its ID
        $movie = Movie::findOrFail($movieId);

        // Determine which filter is applied (default to 0 if not provided)
        $filter = $request->input('filter', 0);

        // Initialize variables for screenings and date range
        $screenings = collect();
        $startDate = Carbon::today();
        $endDate = $startDate->copy()->addWeeks(2);

        // Determine the date range based on the filter
        switch ($filter) {
            case 0:
                // Filter 0: Show screenings for today
                $screenings = $this->getScreeningsForDate($movie, $startDate);
                break;
            case 1:
                // Filter 1: Show screenings for the next two weeks
                $screenings = $this->getScreeningsForDateRange($movie, $startDate, $endDate);
                break;
            case 2:
                $screenings = $movie->screenings;
                break;
            default:
                // Invalid filter, default to showing today's screenings
                $screenings = $this->getScreeningsForDateRange($movie, $startDate, $endDate);
                break;
        }

        return view('movies.show', compact('movie', 'screenings', 'filter'));
    }

    /**
     * Retrieve screenings for a specific date.
     *
     * @param  Movie  $movie
     * @param  Carbon  $date
     * @return mixed
     */
    private function getScreeningsForDate(Movie $movie, Carbon $date)
    {
        $now = Carbon::now();
        $fiveMinutesAgo = $now->copy()->subMinutes(5);

        return $movie->screenings()
            ->whereDate('date', $date->toDateString())
            ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', start_time), '%Y-%m-%d %H:%i:%s') >= ?", [$fiveMinutesAgo])
            ->get();
    }

    /**
     * Retrieve screenings for a date range.
     *
     * @param  Movie  $movie
     * @param  Carbon  $startDate
     * @param  Carbon  $endDate
     * @return mixed
     */
    private function getScreeningsForDateRange(Movie $movie, Carbon $startDate, Carbon $endDate)
    {
        $now = Carbon::now();
        $fiveMinutesAgo = $now->copy()->subMinutes(5);

        return $movie->screenings()
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', start_time), '%Y-%m-%d %H:%i:%s') >= ?", [$fiveMinutesAgo])
            ->get();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie): View
    {
        $genres=Genre::all();
        return view('movies.edit',compact('movie','genres'));
    }

    public function update(Request $request, Movie $movie): RedirectResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'trailer_url' => 'required|url',
            'genre_code' => 'required|string|exists:genres,code|max:20',
            'poster_filename' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max size for image files
            'synopsis' => 'nullable|string',
            'year' => 'required|integer|min:1900|max:2100|digits:4',
        ]);

        // Handle file upload for poster if a new file is uploaded
        if ($request->hasFile('poster_filename')) {
            // Delete the existing poster file if it exists
            if ($movie->poster_filename) {
                Storage::delete('public/posters/' . $movie->poster_filename);
            }

            // Store the new poster file
            $posterPath = $request->file('poster_filename')->store('public/posters');
            $validatedData['poster_filename'] = basename($posterPath);
        } else {
            // If no new file uploaded, keep the existing poster file
            $validatedData['poster_filename'] = $movie->poster_filename;
        }

        // Update the movie record
        $movie->update([
            'title' => $validatedData['title'],
            'year' => $validatedData['year'],
            'trailer_url' => $validatedData['trailer_url'],
            'genre_code' => $validatedData['genre_code'],
            'synopsis' => $validatedData['synopsis'],
            'poster_filename' => $validatedData['poster_filename'],
        ]);

        // Redirect back to the index page with success message
        return redirect()->route('movies.index')->with('success', 'Movie updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        // Delete associated screenings first (assuming a one-to-many relationship)
        foreach ($movie->screenings as $screening) {
            $screening->delete();
        }

        // Delete the movie's poster file if it exists
        if ($movie->poster_filename) {
            Storage::delete('public/posters/' . $movie->poster_filename);
        }

        // Delete the movie record from the database
        $movie->delete();

        // Redirect back to the index page with success message
        return redirect()->route('movies.index')->with('success', 'Movie deleted successfully!');
    }
}
