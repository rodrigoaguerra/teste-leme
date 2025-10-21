@csrf
<div class="mb-4">
    <label class="block font-medium">Projeto</label>
    <select name="project_id" class="w-full border p-2 rounded">
        @foreach($projects as $project)
            <option value="{{ $project->id }}" {{ old('project_id', $task->project_id ?? '') == $project->id  ? 'selected' : '' }} >{{ $project->title }}</option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block font-medium">Usuário</label>
    <select name="user_id" class="w-full border p-2 rounded">
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $task->user_id ?? '') == $user->id ? 'selected' : '' }} >{{ $user->name }}</option>
        @endforeach
    </select>
</div>

@if ($task->id)
    <div class="mb-4">
        <label class="block font-medium">Status</label>
        <select name="status" class="w-full border p-2 rounded">
            <option value="pendente" {{ old('status', $task->status ?? '') == 'pendente' ? 'selected' : '' }}>Pendente</option>
            <option value="em_andamento" {{ old('status', $task->status ?? '') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
            <option value="concluida" {{ old('status', $task->status ?? '') == 'concluida' ? 'selected' : '' }}>Concluída</option>
        </select>
    </div>
@endif

<div class="mb-4">
    <label class="block font-medium">Título</label>
    <input type="text" name="title" value="{{ old('title', $task->title ?? '') }}" class="w-full border p-2 rounded" required>
</div>

<div class="mb-4">
    <label class="block font-medium">Descrição</label>
    <textarea name="description" class="w-full border p-2 rounded" rows="3">{{ old('description', $task->description ?? '') }}</textarea>
</div>

<div class="mb-4 flex gap-4">
    <div class="flex-1">
        <label class="block font-medium">Data de Vencimento</label>
        <input type="date" name="due_date" value="{{ old('due_date', $task->due_date ?? '') }}" class="w-full border p-2 rounded">
    </div>
    <div class="flex-1">
        <label class="block font-medium">Prioridade</label>
        <select name="priority" class="w-full border p-2 rounded">
            <option value="baixa" {{ old('priority', $task->priority ?? '') == 'baixa' ? 'selected' : '' }}>Baixa</option>
            <option value="média" {{ old('priority', $task->priority ?? '') == 'média' ? 'selected' : '' }}>Média</option>
            <option value="alta"  {{ old('priority', $task->priority ?? '') == 'alta' ? 'selected' : '' }}>Alta</option>
        </select>
    </div>
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    {{ $task->exists ? 'Atualizar Tarefa' : 'Criar Tarefa' }}
</button>
