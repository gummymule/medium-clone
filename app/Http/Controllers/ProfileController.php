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
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        if (isset($data['image'])) {
            $originalFilename = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($originalFilename, PATHINFO_FILENAME) . '-avatar.jpg';
            
            $media = $user->addMediaFromRequest('image')
                ->usingFileName($filename)
                ->toMediaCollection('avatar');
            
            $user->image = $media->getUrl('avatar');
        }

        // Handle avatar removal if needed
        if ($request->has('remove_avatar')) {
            $user->clearMediaCollection('avatar');
            $user->image = null; // Clear the column too
        }

        $user->fill($request->except(['image', 'remove_avatar']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

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