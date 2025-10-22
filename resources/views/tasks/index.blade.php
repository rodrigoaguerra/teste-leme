<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Minhas Tarefas') }}
            </h2>
            <a href="{{ route('tasks.create') }}"
               class="inline-flex items-center px-4 py-1 bg-blue-600 border border-transparent rounded-md
                      font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700
                      active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                      transition ease-in-out duration-150">
                + Nova Tarefa
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap gap-4 mb-2 ml-4 items-center">
                    <!-- Status -->
                    <div class="flex flex-col">
                        <select name="status" id="status" class="mt-1 block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Todos os status</option>
                            <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                            <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em andamento</option>
                            <option value="concluida" {{ request('status') == 'concluida' ? 'selected' : '' }}>Concluída</option>
                        </select>
                    </div>

                    <!-- Prioridade -->
                    <div class="flex flex-col">
                        <select name="priority" id="priority" class="mt-1 block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Todas as prioridades</option>
                            <option value="baixa" {{ request('priority') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                            <option value="media" {{ request('priority') == 'media' ? 'selected' : '' }}>Média</option>
                            <option value="alta" {{ request('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                        </select>
                    </div>

                    <!-- Botão -->
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                            Filtrar
                        </button>
                    </div>
                </form>

                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-2">Título</th>
                                <th class="p-2">Projeto</th>
                                <th class="p-2">Prioridade</th>
                                <th class="p-2">Status</th>
                                <th class="p-2 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                                <tr class="border-b">
                                    <td class="p-2">{{ $task->title }}</td>
                                    <td class="p-2">{{ $task->project->title }}</td>
                                    <td class="p-2 capitalize">{{ $task->priority }}</td>
                                    <td class="p-2 capitalize">{{ $task->status }}</td>
                                    <td class="p-2 text-center">
                                        <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:underline">Ver</a>
                                        <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-600 hover:underline">Editar</a>
                                        <button
                                            command="show-modal"
                                            commandfor="dialog"
                                            data-task-id="{{ $task->id }}"
                                            data-task-title="{{ $task->title }}"
                                            class="text-red-600 hover:underline"
                                            >
                                            Excluir
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-gray-500 p-4">Nenhuma tarefa encontrada.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $tasks->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <el-dialog>
        <dialog id="dialog"
            aria-labelledby="dialog-title"
            class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent"
        >
            <el-dialog-backdrop class="fixed inset-0 bg-gray-500/75 transition-opacity data-closed:opacity-0"></el-dialog-backdrop>

            <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
            <el-dialog-panel
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
            >
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        class="size-6 text-red-600">
                        <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"
                        stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 id="dialog-title" class="text-base font-semibold text-gray-900">
                        Confirmar exclusão
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                        Deseja realmente excluir a tarefa
                        <span id="taskTitle" class="font-semibold text-gray-800"></span>?
                        </p>
                    </div>
                    </div>
                </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto"
                        >
                        Excluir
                    </button>
                </form>

                <button
                    type="button"
                    command="close"
                    commandfor="dialog"
                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                >
                    Cancelar
                </button>
                </div>
            </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

</x-app-layout>

<script>
    document.addEventListener('click', function (event) {
        // verifica se clicou num botão que abre o modal
        const button = event.target.closest('[command="show-modal"][commandfor="dialog"]');
        if (!button) return;

        const taskId = button.dataset.taskId;
        const taskTitle = button.dataset.taskTitle;

        // Atualiza conteúdo e ação do form
        document.getElementById('taskTitle').textContent = taskTitle;
        document.getElementById('deleteForm').action = `/tasks/${taskId}`;
    });
</script>

