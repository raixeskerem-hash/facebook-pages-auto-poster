<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskPage;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTasks     = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $pendingTasks   = Task::where('status', 'pending')->count();
        $totalPosts     = TaskPage::whereNotNull('post_id')->count();
        $totalComments  = TaskPage::whereNotNull('comment_id')->count();

        return view('dashboard.index', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'totalPosts',
            'totalComments'
        ));
    }
}
