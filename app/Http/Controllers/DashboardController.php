<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        // Total de tarefas pendentes
        $pendingTasks = Task::where('user_id', $userId)
                            ->where('status', 'pendente')
                            ->count();

        // Total de tarefas atrasadas (pendentes e com due_date menor que hoje)
        $overdueTasks = Task::where('user_id', $userId)
                            ->where('status', 'pendente')
                            ->where('due_date', '<', $today)
                            ->count();

        return view('dashboard', compact('pendingTasks', 'overdueTasks'));
    }
}
