<?php

namespace App\Http\Controllers;

use App\Http\Requests\TheaterFormRequest;
use App\Models\Theater;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $theaters = Theater::all();
        return view('theaters.index')->with('theaters', $theaters);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $newTheater = new Theater();
        return view('theaters.create')->with('theater', $newTheater);;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TheaterFormRequest $request): RedirectResponse
    {
        $newTheater = Theater::create($request->validated());

        if ($request->hasFile('image_file')) {
            $request->image_file->storeAs('public/theaters', $newTheater->photo_filename);
        }
        return redirect()->route('theaters.index');  
    }

    /**
     * Display the specified resource.
     */
    public function show(Theater $theater)
    {
        return view('theaters.show')->with('theater', $theater);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theater $theater)
    {
        return view('theaters.edit')->with('theater', $theater);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theater $theater): RedirectResponse
    {
        return redirect()->route('theaters.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theater $theater): RedirectResponse
    {
        foreach($theater->seats() as $seat){
            $seat->delete();
        }
        foreach($theater->screenings() as $screening){
            $screening->delete();
        }
        $theater->delete();

        return redirect()->route('theaters.index');
    }
}