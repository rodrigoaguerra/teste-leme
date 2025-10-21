<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Exibe todas as tarefas do usuário logado.
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->with('project')
            ->latest()
            ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Formulário para criar nova tarefa.
     * O usuário só pode escolher projetos dos quais é membro.
     */
    public function create()
    {
        $user = Auth::user();

        // Projetos onde o usuário é dono
        $ownProjects = Project::where('user_id', $user->id)->get();

        // Projetos onde o usuário é membro
        $memberProjects = $user->projectMemberships->map(function($membership) {
            return $membership->project; // assumindo que ProjectMember tem um relacionamento 'project'
        });

        // Mesclar coleções
        $projects = $ownProjects->merge($memberProjects);

        $users = User::all();

        return view('tasks.create', compact('projects', 'users'));
    }

    /**
     * Salva nova tarefa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:baixa,média,alta',
        ]);

        // Verifica se o usuário é membro do projeto
        $project = Project::findOrFail($request->project_id);
        $user = Auth::user();

        $isMember = $project->members->contains($user->id) || $project->user_id === $user->id;

        if (! $isMember) {
            abort(403, 'Você não tem permissão para adicionar tarefas a este projeto.');
        }

        Task::create([
            'project_id' => $request->project_id,
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'status' => 'pendente',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit(Task $task)
    {
        $this->authorizeTask($task);
        $user = Auth::user();

        // Projetos onde o usuário é dono
        $ownProjects = Project::where('user_id', $user->id)->get();

        // Projetos onde o usuário é membro
        $memberProjects = $user->projectMemberships->map(function($membership) {
            return $membership->project; // assumindo que ProjectMember tem um relacionamento 'project'
        });

        // Mesclar coleções
        $projects = $ownProjects->merge($memberProjects);

        $users = User::all();

        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:baixa,média,alta',
            'status' => 'required|in:pendente,em_andamento,concluída',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarefa excluída com sucesso!');
    }

    /**
     * Verifica se o usuário é o dono da tarefa ou membro do projeto.
     */
    protected function authorizeTask(Task $task)
    {
        $user = Auth::user();

        $isMember = $task->project->members->contains($user->id) || $task->project->user_id === $user->id;

        if (! $isMember && $task->user_id !== $user->id) {
            abort(403, 'Acesso negado.');
        }
    }
}
