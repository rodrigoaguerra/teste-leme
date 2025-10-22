
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalhes da Tarefa') }}
            </h2>
            <a href="{{ route('tasks.index') }}"
               class="inline-flex items-center px-4 py-1 bg-blue-600 border border-transparent rounded-md
                      font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700
                      active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                      transition ease-in-out duration-150">
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-4">{{ $task->title }}</h2>

                    <p><strong>Descrição:</strong> {{ $task->description }}</p>
                    <p><strong>Conclusão:</strong> {{ $task->due_date }}</p>
                    <p><strong>Prioridade:</strong> {{ $task->priority }}</p>
                    <p><strong>Status:</strong> {{ $task->status }}</p>
                    <p><strong>Projeto:</strong> {{ $task->project->title }}</p>
                    <p><strong>Usuário:</strong> {{ $task->user->name }}</p>
                    <p><strong>Arquivos:</strong></p>

                    @if(!empty($task) && $task->attachments->isNotEmpty())
                        @foreach ($task->attachments as $attachment)
                            <p class="text-sm mt-1">
                                <a href="{{ asset('storage/'. $attachment->file_path) }}" target="_blank" class="text-blue-600 underline">Ver arquivo</a>
                            </p>
                        @endforeach
                    @endif

                    <a href="{{ route('tasks.index') }}" class="mt-4 inline-block bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
