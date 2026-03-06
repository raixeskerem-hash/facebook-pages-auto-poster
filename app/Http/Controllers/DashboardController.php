<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Example dynamic data; replace this with your actual logic to fetch statistics
        $totalTasks = 100;
        $completedTasks = 75;
        $pendingTasks = 20;
        $failedTasks = 5;
        $completionRate = ($completedTasks / $totalTasks) * 100;

        return response()->json([
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'pending_tasks' => $pendingTasks,
            'failed_tasks' => $failedTasks,
            'completion_rate' => $completionRate,
        ]);
    }
}
