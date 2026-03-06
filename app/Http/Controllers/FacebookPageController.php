<?php

namespace App\Http\Controllers;

use App\Models\FacebookPage;
use App\Models\FacebookProfile;
use Illuminate\Http\Request;

class FacebookPageController extends Controller
{
    public function index()
    {
        $pages = FacebookPage::with('profile')->get();
        return view('pages.index', compact('pages'));
    }

    public function create()
    {
        $profiles = FacebookProfile::all();
        return view('pages.create', compact('profiles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_id'   => 'required|integer|exists:facebook_profiles,id',
            'page_id'      => 'required|string|max:255|unique:facebook_pages,page_id',
            'name'         => 'required|string|max:255',
            'access_token' => 'nullable|string',
        ]);

        FacebookPage::create($validated);
        return redirect()->route('pages.index')->with('success', 'Sayfa başarıyla oluşturuldu.');
    }

    public function edit(FacebookPage $page)
    {
        $profiles = FacebookProfile::all();
        return view('pages.edit', compact('page', 'profiles'));
    }

    public function update(Request $request, FacebookPage $page)
    {
        $validated = $request->validate([
            'profile_id'   => 'required|integer|exists:facebook_profiles,id',
            'page_id'      => 'required|string|max:255|unique:facebook_pages,page_id,' . $page->id,
            'name'         => 'required|string|max:255',
            'access_token' => 'nullable|string',
        ]);

        $page->update($validated);
        return redirect()->route('pages.index')->with('success', 'Sayfa başarıyla güncellendi.');
    }

    public function destroy(FacebookPage $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Sayfa başarıyla silindi.');
    }
}
