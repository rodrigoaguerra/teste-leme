@csrf
<div class="mb-4">
    <label class="block font-medium">Projeto</label>
    <select id="project_id" name="project_id" class="w-full border p-2 rounded">
        @foreach($projects as $project)
            <option value="{{ $project->id }}" {{ old('project_id', $task->project_id ?? '') == $project->id  ? 'selected' : '' }} >{{ $project->title }}</option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block font-medium">Usuário</label>
    <select id="user_id" name="user_id" class="w-full border p-2 rounded">
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $task->user_id ?? '') == $user->id ? 'selected' : '' }} >{{ $user->name }}</option>
        @endforeach
    </select>
</div>

@if (!empty($task))
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

<div class="mb-4">
    <label class="block font-medium">Arquivos (PDF/Imagem)</label>
    <input type="file" name="attachments[]" multiple="w-full border p-2 rounded">
    @if(!empty($task) && $task->attachments->isNotEmpty())
        @foreach ($task->attachments as $attachment)
            <p class="text-sm mt-1">Arquivo:
                <a href="{{ asset('storage/'. $attachment->file_path) }}" target="_blank" class="text-blue-600 underline">Ver arquivo</a>
            </p>
        @endforeach
    @endif
</div>

<div class="mb-4 flex gap-4">
    <div class="flex-1">
        <label class="block font-medium">Data de Vencimento</label>
        <input type="date" name="due_date" value="{{ old('due_date', $task->due_date ?? '') }}" class="w-full border p-2 rounded" required>
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
    {{ !empty($task) ? 'Atualizar Tarefa' : 'Criar Tarefa' }}
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const projectSelect = document.getElementById('project_id');
    const userSelect = document.getElementById('user_id');
    const selectedUserId = "{{ old('user_id', $task->user_id ?? '') }}";

    // Função que carrega os membros via AJAX
    function loadProjectMembers(projectId, preselectUserId = null) {
        if (!projectId) {
            userSelect.innerHTML = '<option value="">Selecione um projeto primeiro</option>';
            return;
        }

        userSelect.innerHTML = '<option value="">Carregando...</option>';

        fetch(`/projects/${projectId}/members`)
            .then(response => response.json())
            .then(users => {
                userSelect.innerHTML = '<option value="">Selecione um usuário</option>';
                users.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    option.textContent = user.name;
                    if (preselectUserId && user.id == preselectUserId) {
                        option.selected = true;
                    }
                    userSelect.appendChild(option);
                });
            })
            .catch(() => {
                userSelect.innerHTML = '<option value="">Erro ao carregar usuários</option>';
            });
    }

    // Quando mudar o projeto
    projectSelect.addEventListener('change', function() {
        loadProjectMembers(this.value);
    });

    // Ao carregar a página, se já houver um projeto selecionado (ex: editando tarefa)
    const initialProjectId = projectSelect.value;
    if (initialProjectId) {
        loadProjectMembers(initialProjectId, selectedUserId);
    }

    const selects = document.querySelectorAll('select');

    selects.forEach(select => {
        const updateRequired = () => {
            if (select.value === '') {
                select.setAttribute('required', 'required');
            } else {
                select.removeAttribute('required');
            }
        };

        // Atualiza quando muda e no carregamento inicial
        select.addEventListener('change', updateRequired);
        updateRequired();
    });
});
</script>
