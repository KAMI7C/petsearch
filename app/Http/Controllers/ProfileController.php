<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Post; // 👈 ДОБАВЛЯЕМ ЭТОТ ИМПОРТ

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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
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

    // ============= 👇 НАШИ НОВЫЕ МЕТОДЫ ДОБАВЛЯЕМ СЮДА =============

    /**
     * Show user profile with posts and favorites
     */
    public function show()
    {
        $user = Auth::user()->load(['posts' => function($q) {
            $q->latest();
        }, 'favoritePosts' => function($q) {
            $q->latest();
        }]);

        return view('profile.show', compact('user'));
    }

    /**
     * Update user contact info
     */
    public function updateContact(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'social' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($data);

        return redirect()->route('profile.show')
                         ->with('success', 'Профиль обновлён');
    }

    /**
     * Close post (mark as not active)
     */
    public function closePost($id)
    {
        $post = Post::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
        
        $post->update(['is_active' => false]);

        return back()->with('success', 'Объявление закрыто');
    }
}