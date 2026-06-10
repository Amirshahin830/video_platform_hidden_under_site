<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'avatar'   => $this->generateAvatar($request->name),
            'password' => Hash::make($validated['password']),
        ]);

        // Log them in
        Auth::login($user);

        // Redirect to home
        return redirect()->route('home');
    }

    // AvatarController.php
    public function generateAvatar(string $name): string
    {
        $initials = collect(explode(' ', $name))
            ->take(2)
            ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->join('');

        $colors = ['e74c3c', '3498db', '2ecc71', 'f39c12', '9b59b6', '1abc9c', 'e67e22'];
        $color  = $colors[abs(crc32($name)) % count($colors)];

        $svg = <<<SVG
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100">
                    <circle cx="50" cy="50" r="50" fill="#{$color}"/>
                    <text x="50%" y="50%" dy=".35em" text-anchor="middle"
                          font-family="Arial" font-size="40" fill="#fff">{$initials}</text>
                </svg>
                SVG;

        $filename = 'avatars/' . \Str::uuid() . '.svg';
        \Storage::disk('public')->put($filename, $svg);

        return $filename;
    }

}
