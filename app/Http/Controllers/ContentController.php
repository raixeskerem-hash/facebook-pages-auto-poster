<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::all();
        return view('contents.index', compact('contents'));
    }

    public function create()
    {
        return view('contents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'text'                 => 'required|string',
            'media_type'           => 'nullable|in:image,video',
            'media_path'           => 'nullable|string|max:255',
            'link_url'             => 'nullable|url|max:255',
            'comment_enabled'      => 'nullable|boolean',
            'comment_text'         => 'nullable|string',
            'comment_link'         => 'nullable|url|max:255',
            'comment_wait_seconds' => 'nullable|integer|min:0',
            'status'               => 'required|in:active,inactive',
        ]);

        $validated['comment_enabled'] = $request->boolean('comment_enabled');

        Content::create($validated);
        return redirect()->route('contents.index')->with('success', 'İçerik başarıyla oluşturuldu.');
    }

    public function edit(Content $content)
    {
        return view('contents.edit', compact('content'));
    }

    public function update(Request $request, Content $content)
    {
        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'text'                 => 'required|string',
            'media_type'           => 'nullable|in:image,video',
            'media_path'           => 'nullable|string|max:255',
            'link_url'             => 'nullable|url|max:255',
            'comment_enabled'      => 'nullable|boolean',
            'comment_text'         => 'nullable|string',
            'comment_link'         => 'nullable|url|max:255',
            'comment_wait_seconds' => 'nullable|integer|min:0',
            'status'               => 'required|in:active,inactive',
        ]);

        $validated['comment_enabled'] = $request->boolean('comment_enabled');

        $content->update($validated);
        return redirect()->route('contents.index')->with('success', 'İçerik başarıyla güncellendi.');
    }

    public function destroy(Content $content)
    {
        $content->delete();
        return redirect()->route('contents.index')->with('success', 'İçerik başarıyla silindi.');
    }
}
