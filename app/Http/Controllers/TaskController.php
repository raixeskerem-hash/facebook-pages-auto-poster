<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\FacebookPage;
use App\Models\Content;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('facebookPage', 'content')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $pages = FacebookPage::all();
        $contents = Content::all();
        return view('tasks.create', compact('pages', 'contents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'facebook_page_id' => 'required|integer|exists:facebook_pages,id',
            'content_id' => 'required|integer|exists:contents,id',
            'status' => 'required|in:pending,scheduled,completed,failed',
        ]);

        Task::create($validated);
        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla oluşturuldu.');
    }

    public function edit(Task $task)
    {
        $pages = FacebookPage::all();
        $contents = Content::all();
        return view('tasks.edit', compact('task', 'pages', 'contents'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'facebook_page_id' => 'required|integer|exists:facebook_pages,id',
            'content_id' => 'required|integer|exists:contents,id',
            'status' => 'required|in:pending,scheduled,completed,failed',
        ]);

        $task->update($validated);
        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla güncellendi.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla silindi.');
    }
}