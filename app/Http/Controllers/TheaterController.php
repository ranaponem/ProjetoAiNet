<?php

namespace App\Http\Controllers;

use App\Http\Requests\TheaterFormRequest;
use App\Models\Theater;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $validatedData = $request->validated();
        $newTheater = DB::transaction(function () use ($validatedData, $request) {
            $newTheater = new Theater();
            $newTheater->name = $validatedData['name'];
            $newTheater->save();
            if ($request->hasFile('image_file')) {
                $path = $request->image_file->store('public/photos');
                $newTheater->photo_filename = basename($path);
                $newTheater->save();
            }
            return $newTheater;
        });
        return redirect()->route('theaters.index');  
    }

    /**
     * Display the specified resource.
     */
    public function show(Theater $theater)
    {
        //return view('theaters.show')->with('theater', $theater);
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