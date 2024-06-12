<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AdministrativeFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdministrativeController extends Controller
{
    public function index(Request $request): View
    {
        $administrativesQuery = User::where('type', 'A')
            ->orderBy('name');
        $filterByName = $request->query('name');
        if ($filterByName) {
            $administrativesQuery->where('name', 'like', "%$filterByName%");
        }
        $administratives = $administrativesQuery
            ->paginate(20)
            ->withQueryString();

        return view(
            'administratives.index',
            compact('administratives', 'filterByName')
        );
    }


    public function show(User $administrative): View
    {
        return view('administratives.show')->with('administrative', $administrative);
    }

    public function create(): View
    {
        $newAdministrative = new User();
        $newAdministrative->type = 'A';
        return view('administratives.create')
            ->with('administrative', $newAdministrative);
    }

    public function store(AdministrativeFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $newAdministrative = new User();
        $newAdministrative->type = 'A';
        $newAdministrative->name = $validatedData['name'];
        $newAdministrative->email = $validatedData['email'];
        $newAdministrative->admin = $validatedData['admin'];
        $newAdministrative->gender = $validatedData['gender'];
        // Initial password is always 123
        $newAdministrative->password = bcrypt('123');
        $newAdministrative->save();
        if ($request->hasFile('photo_file')) {
            $path = $request->photo_file->store('public/photos');
            $newAdministrative->photo_url = basename($path);
            $newAdministrative->save();
        }
        $url = route('administratives.show', ['administrative' => $newAdministrative]);
        $htmlMessage = "Administrative <a href='$url'><u>{$newAdministrative->name}</u></a> has been created successfully!";
        return redirect()->route('administratives.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(User $administrative): View
    {
        return view('administratives.edit')
            ->with('administrative', $administrative);
    }

    public function update(AdministrativeFormRequest $request, User $administrative): RedirectResponse
    {
        $validatedData = $request->validated();
        $administrative->type = 'A';
        $administrative->name = $validatedData['name'];
        $administrative->email = $validatedData['email'];
        $administrative->admin = $validatedData['admin'];
        $administrative->gender = $validatedData['gender'];
        $administrative->save();
        if ($request->hasFile('photo_file')) {
            // Delete previous file (if any)
            if (
                $administrative->photo_url &&
                Storage::fileExists('public/photos/' . $administrative->photo_url)
            ) {
                Storage::delete('public/photos/' . $administrative->photo_url);
            }
            $path = $request->photo_file->store('public/photos');
            $administrative->photo_url = basename($path);
            $administrative->save();
        }
        $url = route('administratives.show', ['administrative' => $administrative]);
        $htmlMessage = "Administrative <a href='$url'><u>{$administrative->name}</u></a> has been updated successfully!";
        return redirect()->route('administratives.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(User $administrative): RedirectResponse
    {
        try {
            $url = route('administratives.show', ['administrative' => $administrative]);
            $fileToDelete = $administrative->photo_url;
            $administrative->delete();
            if ($fileToDelete) {
                if (Storage::fileExists('public/photos/' . $fileToDelete)) {
                    Storage::delete('public/photos/' . $fileToDelete);
                }
            }
            $alertType = 'success';
            $alertMsg = "Administrative {$administrative->name} has been deleted successfully!";
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the administrative
                            <a href='$url'><u>{$administrative->name}</u></a>
                            because there was an error with the operation!";
        }
        return redirect()->route('administratives.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function destroyPhoto(User $administrative): RedirectResponse
    {
        if ($administrative->photo_url) {
            if (Storage::fileExists('public/photos/' . $administrative->photo_url)) {
                Storage::delete('public/photos/' . $administrative->photo_url);
            }
            $administrative->photo_url = null;
            $administrative->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Photo of administrative {$administrative->name} has been deleted.");
        }
        return redirect()->back();
    }
}
