<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\FacebookProfile;
use App\Models\FacebookPage;
use App\Models\Content;
use App\Services\PostingService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected PostingService $postingService;

    public function __construct(PostingService $postingService)
    {
        $this->postingService = $postingService;
    }

    public function index()
    {
        $tasks = Task::with('profile', 'content')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $profiles = FacebookProfile::all();
        $pages    = FacebookPage::all();
        $contents = Content::all();
        return view('tasks.create', compact('profiles', 'pages', 'contents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'facebook_profile_id' => 'required|integer|exists:facebook_profiles,id',
            'content_id'          => 'required|integer|exists:contents,id',
            'status'              => 'required|in:pending,scheduled,processing,completed,failed',
            'scheduled_at'        => 'nullable|date',
            'page_ids'            => 'nullable|array',
            'page_ids.*'          => 'integer|exists:facebook_pages,id',
        ]);

        $pageIds = $request->input('page_ids', []);
        unset($validated['page_ids']);
        $validated['total_pages']     = count($pageIds);
        $validated['completed_pages'] = 0;

        $task = Task::create($validated);
        $task->pages()->sync($pageIds);

        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla oluşturuldu.');
    }

    public function edit(Task $task)
    {
        $profiles = FacebookProfile::all();
        $pages    = FacebookPage::all();
        $contents = Content::all();
        return view('tasks.edit', compact('task', 'profiles', 'pages', 'contents'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'facebook_profile_id' => 'required|integer|exists:facebook_profiles,id',
            'content_id'          => 'required|integer|exists:contents,id',
            'status'              => 'required|in:pending,scheduled,processing,completed,failed',
            'scheduled_at'        => 'nullable|date',
            'page_ids'            => 'nullable|array',
            'page_ids.*'          => 'integer|exists:facebook_pages,id',
        ]);

        $pageIds = $request->input('page_ids', []);
        unset($validated['page_ids']);
        $validated['total_pages'] = count($pageIds);

        $task->update($validated);
        $task->pages()->sync($pageIds);

        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla güncellendi.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla silindi.');
    }

    public function execute(Task $task)
    {
        if (!$task->isReadyToRun()) {
            return redirect()->route('tasks.index')->with('error', 'Görev çalıştırılmaya hazır değil.');
        }

        $task->status = 'processing';
        $task->save();

        try {
            $this->postingService->executeBatchTask($task);
        } catch (\Throwable $e) {
            $task->status = 'failed';
            $task->save();
            return redirect()->route('tasks.index')->with('error', 'Görev çalıştırılırken hata oluştu: ' . $e->getMessage());
        }

        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla çalıştırıldı.');
    }
}
