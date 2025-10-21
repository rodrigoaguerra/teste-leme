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
                                        <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-600 hover:underline">Editar</a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:underline" onclick="return confirm('Excluir tarefa?')">Excluir</button>
                                        </form>
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
</x-app-layout>
