<?php

namespace App\Http\Controllers;

use App\Http\Requests\TheaterCreateFormRequest;
use App\Http\Requests\TheaterUpdateFormRequest;
use App\Models\Seat;
use App\Models\Theater;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TheaterController extends Controller
{

    use AuthorizesRequests;

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
    public function store(TheaterCreateFormRequest $request): RedirectResponse
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

        for($i = 1 ; $i <= $validatedData['rows'] ; $i++){
            for($j = 1 ; $j <= $validatedData['cols'] ; $j++){
                $newSeat = DB::transaction(function () use ($i, $j, $newTheater) {
                    $newSeat = new Seat();
                    $newSeat->theater_id = $newTheater->id;
                    $newSeat->row = chr(ord('A') + $i - 1);
                    $newSeat->seat_number = $j;
                    $newSeat->save();
                    return $newSeat;
                });
            }
        }
        return redirect()->route('theaters.index');  
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
    public function update(TheaterUpdateFormRequest $request, Theater $theater): RedirectResponse
    {
        $validatedData = $request->validated();
        $theater = DB::transaction(function () use ($validatedData, $theater, $request) {
            $theater->name = $validatedData['name'];
            $theater->save();
            if ($request->hasFile('image_file')) {
                if (
                    $theater->photo_filename &&
                    Storage::fileExists('public/photos/' . $theater->photo_filename)
                ) {
                    Storage::delete('public/photos/' . $theater->photo_filename);
                }
                $path = $request->image_file->store('public/photos');
                $theater->photo_filename = basename($path);
                $theater->save();
            }
            return $theater;
        });
        
        return redirect()->route('theaters.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theater $theater): RedirectResponse
    {
        foreach($theater->seats as $seat){
            $seat->delete();
        }
        foreach($theater->screenings as $screening){
            $screening->delete();
        }
        $theater->delete();

        return redirect()->route('theaters.index');
    }

    public function destroyPhoto(Theater $theater): RedirectResponse
    {
        if ($theater->photo_filename) {
            if (Storage::fileExists('public/photos/' . $theater->photo_filename)) {
                Storage::delete('public/photos/' . $theater->photo_filename);
            }
            $theater->photo_filename = null;
            $theater->save();
            return redirect()->back();
        }
        return redirect()->back();
    }
}