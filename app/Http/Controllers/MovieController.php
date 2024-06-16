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

        $movies = $query->get();

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

        $moviesOnShow = $query->get();

        return view('movies.indexOnShow',compact('moviesOnShow', 'genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('movies.index');
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
        return view('movies.create')->with('movie', $movie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        return redirect()->route('movies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        foreach($movie->screenings() as $screening){
            $screening->delete();
        }
        $movie->delete();
        return redirect()->route('movies.index');
    }
}
