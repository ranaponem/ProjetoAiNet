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

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);

        // Validate the request data including the file upload
        $validatedData = $request->validated();

        try {
            // Update user's name and email
            $user->fill([
                'name' => $validatedData['name'] ?? $user->name,
                'email' => $validatedData['email'] ?? $user->email,
            ]);

            // Check if the email has changed
            if ($user->isDirty('email')) {
                $user->email_verified_at = null; // Reset email verification status
            }

            // Handle image upload
            if ($request->hasFile('photo_filename')) {
                // Delete old image if exists
                if ($user->photo_filename && Storage::exists('public/photos/' . $user->photo_filename)) {
                    Storage::delete('public/photos/' . $user->photo_filename);
                }

                // Store new image
                $path = $request->file('photo_filename')->store('public/photos');
                $user->photo_filename = basename($path);
            }

            // Save the user model
            $user->save();

            return redirect()->route('profile.edit')->with('status', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update profile. ' . $e->getMessage());
        }
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
        if ($user->photo_filename) {
            if (Storage::fileExists('public/photos/' . $user->photo_filename)) {
                Storage::delete('public/photos/' . $user->photo_filename);
            }
            $user->photo_filename = null;
            $user->save();
            return redirect()->back();
        }
        return redirect()->back();
    }
}
