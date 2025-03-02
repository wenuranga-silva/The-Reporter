<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserDescription;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('frontend.pages.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());


        if ($request->hasFile('profile_picture')) {

            $request->user()->photo = $this->updateImage($request ,'profile_picture' ,'/uploads/profile/' ,$request->user()->photo);
        }


        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    public function add_description(Request $request) {

        $request->validate([

            'description' => ['required' ,'string']
        ]);

        $count = UserDescription::where('author' ,$request->user()->id)->count();

        if ($count != 0) {

            $id = UserDescription::where('author' ,$request->user()->id)->first()->id;
            $desc = UserDescription::findOrFail($id);
            $desc->description = $request->description;
            $desc->update();

        } else {

            $desc = new UserDescription();
            $desc->author = $request->user()->id;
            $desc->description = $request->description;
            $desc->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
