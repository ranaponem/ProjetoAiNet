<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
    public function show(Movie $movie): View
    {
        $now = Carbon::now();
        $fiveMinutesAgo = $now->copy()->subMinutes(5);
        $screenings = $movie->screenings()
                            ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', start_time), '%Y-%m-%d %H:%i:%s') >= ?", [$fiveMinutesAgo])
                            ->get();

        return view('movies.show')
            ->with('movie', $movie)->with('screenings', $screenings)->with('time', $now);
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
