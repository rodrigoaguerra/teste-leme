<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Meus Projetos') }}
            </h2>
            <a href="{{ route('projects.create') }}"
               class="inline-flex items-center px-4 py-1 bg-blue-600 border border-transparent rounded-md
                      font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700
                      active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                      transition ease-in-out duration-150">
                + Novo Projeto
            </a>
        </div>
    </x-slot>

   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full bg-white shadow rounded">
                        <thead>
                            <tr class="bg-gray-200 text-left">
                                <th class="p-3">Título</th>
                                <th class="p-3">Início</th>
                                <th class="p-3">Conclusão</th>
                                <th class="p-3 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $project->title }}</td>
                                <td class="p-3">{{ $project->start_date }}</td>
                                <td class="p-3">{{ $project->end_date }}</td>
                                <td class="p-3 text-center space-x-2">
                                    <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">Ver</a>
                                    <a href="{{ route('projects.edit', $project) }}" class="text-yellow-600 hover:underline">Editar</a>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Deseja excluir este projeto?')" class="text-red-600 hover:underline">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{-- {{ $projects->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
