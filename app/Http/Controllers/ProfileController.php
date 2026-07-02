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
        $user = $request->user();
        $bankAccounts = $user->bankAccounts()->get();

        return view('profile.edit', [
            'user'         => $user,
            'bankAccounts' => $bankAccounts,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        // Handle delete avatar request
        if ($request->input('delete_avatar') === '1') {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = null;
        }

        // Handle new avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Remove avatar from validated array so fill() doesn't overwrite it with the file object
        unset($validated['avatar']);

        // Gabungkan field alamat terstruktur menjadi satu string untuk kolom `address`
        $parts = array_filter([
            $validated['detail_address'] ?? null,
            $validated['village']        ?? null,
            $validated['district']       ?? null,
            $validated['city']           ?? null,
            $validated['province']       ?? null,
        ]);
        $validated['address'] = implode(', ', $parts);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

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

    /**
     * Update the user's theme color. (legacy — backward compat)
     */
    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme_color' => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
        ]);

        $user = $request->user();
        $user->theme_color = $request->theme_color;
        $user->save();

        return response()->json([
            'success'     => true,
            'theme_color' => $user->theme_color
        ]);
    }

    /**
     * Update the user's full theme settings (light + dark + mode).
     */
    public function updateThemeSettings(Request $request)
    {
        $request->validate([
            'mode'              => ['required', 'in:light,dark,system'],
            'light.bg'          => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'light.fg'          => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'light.accent'      => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'dark.bg'           => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'dark.fg'           => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'dark.accent'       => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
        ]);

        $user = $request->user();
        $user->theme_settings = [
            'mode'  => $request->input('mode'),
            'light' => [
                'bg'     => $request->input('light.bg'),
                'fg'     => $request->input('light.fg'),
                'accent' => $request->input('light.accent'),
            ],
            'dark'  => [
                'bg'     => $request->input('dark.bg'),
                'fg'     => $request->input('dark.fg'),
                'accent' => $request->input('dark.accent'),
            ],
        ];
        // Also update legacy theme_color to current accent for compatibility
        $mode = $request->input('mode') === 'dark' ? 'dark' : 'light';
        $user->theme_color = $request->input("{$mode}.accent");
        $user->save();

        return response()->json(['success' => true, 'theme_settings' => $user->theme_settings]);
    }
}

