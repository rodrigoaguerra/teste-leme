<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $search = $request->input('search'); // recebe o termo de busca

        $projects = Project::where(function ($query) use ($userId) {
                $query->where('user_id', $userId) // é dono
                    ->orWhereHas('members', function ($query) use ($userId) {
                        $query->where('user_id', $userId); // é membro via ProjectMember
                    });
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->with(['members.user']) // carrega os membros e seus usuários
            ->latest()
            ->paginate(10)
            ->withQueryString(); // mantém o termo de busca na paginação

        return view('projects.index', compact('projects', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get(); // Exclude current user

        return view('projects.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:150',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'attachment' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'members' => 'required|array|min:1',
        ]);

        // Upload the attachment
        $filePath = $request->file('attachment')
            ? $request->file('attachment')->store('projects', 'public')
            : null;

        // Create the project
        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'attachment' => $filePath,
        ]);

        $project->members()->create([
            'user_id' => Auth::id(),
            'role' => 'owner',
        ]);

        // Add members
        foreach ($request->members as $memberId) {
            $project->members()->create([
                'user_id' => $memberId,
                'role' => 'member',
            ]);
        }

        return redirect()->route('projects.index')->with('success', 'Projeto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $users = User::where('id', '!=', Auth::id())->get(); // Exclude current user

        return view('projects.edit', compact('project', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|max:150',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'attachment' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filePath = $project->attachment;
        if ($request->hasFile('attachment')) {
            if ($filePath) Storage::disk('public')->delete($filePath);
            $filePath = $request->file('attachment')->store('projects', 'public');
        }

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'attachment' => $filePath,
        ]);

        return redirect()->route('projects.index')->with('success', 'Projeto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->file_path) {
            Storage::disk('public')->delete($project->file_path);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Projeto excluído com sucesso!');
    }

    /**
     * List members of a project.
     */
    public function members($projectId)
    {
        $project = Project::with('members.user') // supondo relação ProjectMember -> user()
            ->findOrFail($projectId);

        // monta lista de usuários (membros + dono, se quiser)
        $users = $project->members->pluck('user')->prepend($project->owner)->unique('id')->values();

        return response()->json($users);
    }
}
