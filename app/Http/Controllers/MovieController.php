<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(15);

        $moviesOnShow = Movie::whereHas('screenings', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        })->get();

        return view('movies.index')
            ->with('moviesOnShow', $moviesOnShow);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}