
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalhes do Projeto') }}
            </h2>
            <a href="{{ route('projects.index') }}"
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
                    <h2 class="text-2xl font-semibold mb-4">{{ $project->title }}</h2>

                    <p><strong>Descrição:</strong> {{ $project->description }}</p>
                    <p><strong>Início:</strong> {{ $project->start_date }}</p>
                    <p><strong>Conclusão:</strong> {{ $project->end_date }}</p>
                    <p><strong>Membros:</strong> {{ implode(', ', $project->members->pluck('user.name')->toArray()) }}</p>

                    @if($project->attachment)
                        <p class="mt-2">
                            <a href="{{ asset('storage/'.$project->attachment) }}" target="_blank" class="text-blue-600 underline">
                                Ver arquivo anexado
                            </a>
                        </p>
                    @endif
                    <br />
                    <p><strong>Tarefas:</strong></p>
                    <ul>
                        @foreach($project->tasks as $task)
                            <li>
                                <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:underline">
                                    {{ $task->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('projects.index') }}" class="mt-4 inline-block bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
