<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Role;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = null;
        $users = null;
        $roles = null;

        if (Auth::user()->hasRole('admin')) {
            $stats = [
                'videos'      => Video::count(),
                'views'       => Video::sum('views'),
                'users'       => User::count(),
                'likes_today' => Like::whereDate('created_at', today())->count(),
            ];

            $users = User::with('roles')
                ->where('id', '!=', Auth::id())
                ->latest()
                ->paginate(10);

            $roles = Role::all();
        }

        return view('dashboard', compact('stats', 'users', 'roles'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'اطلاعات با موفقیت ذخیره شد.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'رمز عبور فعلی اشتباه است.',
            'password.min'                      => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
            'password.confirmed'                => 'تکرار رمز عبور مطابقت ندارد.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'رمز عبور با موفقیت تغییر کرد.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'نمی‌توانی نقش خودت را تغییر دهی.');
        }

        $user->roles()->sync([$request->role_id]);

        return back()->with('success', "نقش {$user->name} تغییر کرد.");
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'نمی‌توانی حساب خودت را حذف کنی.');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return back()->with('success', 'کاربر حذف شد.');
    }
}
