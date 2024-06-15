<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\ProfileUpdateRequest;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Redirect;
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

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/');
        }
    }
