<?php

namespace App\Http\Controllers;

use App\Models\FacebookProfile;
use App\Models\Proxy;
use Illuminate\Http\Request;

class FacebookProfileController extends Controller
{
    public function index()
    {
        $profiles = FacebookProfile::with('proxy')->get();
        return view('profiles.index', compact('profiles'));
    }

    public function create()
    {
        $proxies = Proxy::all();
        return view('profiles.create', compact('proxies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'profile_name'     => 'nullable|string|max:255',
            'profile_username' => 'nullable|string|max:255',
            'profile_email'    => 'nullable|email|max:255',
            'profile_password' => 'nullable|string|max:255',
            'status'           => 'required|in:active,inactive',
            'proxy_id'         => 'nullable|integer|exists:proxies,id',
            'notes'            => 'nullable|string',
        ]);

        FacebookProfile::create($validated);
        return redirect()->route('profiles.index')->with('success', 'Profil başarıyla oluşturuldu.');
    }

    public function edit(FacebookProfile $profile)
    {
        $proxies = Proxy::all();
        return view('profiles.edit', compact('profile', 'proxies'));
    }

    public function update(Request $request, FacebookProfile $profile)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'profile_name'     => 'nullable|string|max:255',
            'profile_username' => 'nullable|string|max:255',
            'profile_email'    => 'nullable|email|max:255',
            'profile_password' => 'nullable|string|max:255',
            'status'           => 'required|in:active,inactive',
            'proxy_id'         => 'nullable|integer|exists:proxies,id',
            'notes'            => 'nullable|string',
        ]);

        $profile->update($validated);
        return redirect()->route('profiles.index')->with('success', 'Profil başarıyla güncellendi.');
    }

    public function destroy(FacebookProfile $profile)
    {
        $profile->delete();
        return redirect()->route('profiles.index')->with('success', 'Profil başarıyla silindi.');
    }
}
