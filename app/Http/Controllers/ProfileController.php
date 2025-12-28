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
            'employee' => Auth::user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $employee = $request->user();
        $profile = $employee->profile ?? $employee->profile()->create([]);
        $profile->fill($request->validated());
        $profile->save();
        return redirect()->back()->with('success', __('Updated successfully.'));
    }

    
}
