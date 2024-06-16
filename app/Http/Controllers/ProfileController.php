<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Fill the user model with validated data
        $user->fill($request->validated());

        // Check if the email has changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null; // Reset email verification status
        }

        // Handle image upload
        if ($request->hasFile('image_file')) {
            // Delete old image if exists
            if ($user->photo_filename && Storage::exists('public/photos/' . $user->photo_filename)) {
                Storage::delete('public/photos/' . $user->photo_filename);
            }

            // Store new image
            $path = $request->file('image_file')->store('public/photos');
            $user->photo_filename = basename($path);
        }

        // Save the user model
        $user->save();

        // Redirect back to the edit profile form with a success message
        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Delete user image if exists
        if ($user->photo_filename && Storage::exists('public/photos/' . $user->photo_filename)) {
            Storage::delete('public/photos/' . $user->photo_filename);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function destroyPhoto(): RedirectResponse
    {
        // Authorize the action using UserPolicy
        $user= Auth::user();
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
