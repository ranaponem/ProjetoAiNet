<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Requests\ProfileUpdateRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;

// Import the custom form request

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->get();

        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'type' => 'nullable|string|in:A,C,E', // Assuming 'A', 'C', and 'E' are valid types
            'blocked' => 'nullable|boolean',
            'image_file' => 'nullable|image|max:10048', // Adjust the max size as needed
        ]);

        if ($request->has('email') && $request->input('email') !== $user->email) {
            $user->email_verified_at = null; // Reset email verification status
        }

        // Update other fields if they exist in the validated data
        if (isset($validatedData['name'])) {
            $user->name = $validatedData['name'];
        }
        if (isset($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }
        if (isset($validatedData['type'])) {
            $user->type = $validatedData['type'];
        }
        if (isset($validatedData['blocked'])) {
            $user->blocked = $validatedData['blocked'];
        }

        // Handle file upload for the profile photo
        if ($request->hasFile('image_file')) {
            // Delete old image if exists
            if ($user->photo_filename && Storage::exists('public/photos/' . $user->photo_filename)) {
                Storage::delete('public/photos/' . $user->photo_filename);
            }

            // Store new image
            $path = $request->file('image_file')->store('public/photos');
            $user->photo_filename = basename($path);
        }

        $user->save();

        return redirect()->route('users.edit', ['user' => $user->id])->with('status', 'profile-updated');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $customer = $user->customer;
            if ($customer) {
                $customer->delete();
            }
            $user->delete();

            // Delete user image if exists
            if ($user->photo_filename && Storage::exists('public/photos/' . $user->photo_filename)) {
                Storage::delete('public/photos/' . $user->photo_filename);
            }

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete user. ' . $e->getMessage());
        }
    }

    public function destroyPhoto(User $user): RedirectResponse
    {
        // Authorize the action using UserPolicy
        $this->authorize('destroyPhoto', $user);

        try {
            if ($user->photo_filename) {
                if (Storage::exists('public/photos/' . $user->photo_filename)) {
                    Storage::delete('public/photos/' . $user->photo_filename);
                }
                $user->photo_filename = null;
                $user->save();
            }
            return redirect()->back()->with('status', 'User photo deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete user photo. ' . $e->getMessage());
        }
    }

}
