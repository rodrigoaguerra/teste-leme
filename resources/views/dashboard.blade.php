<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Tarefas Pendentes -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-500">
                    <h3 class="text-lg font-medium text-gray-700">Tarefas Pendentes</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $pendingTasks }}</p>
                    <p class="text-gray-500 mt-1">Tarefas ainda não concluídas.</p>
                </div>

                <!-- Tarefas Atrasadas -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-red-500">
                    <h3 class="text-lg font-medium text-gray-700">Tarefas Atrasadas</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $overdueTasks }}</p>
                    <p class="text-gray-500 mt-1">Tarefas que já passaram da data de entrega.</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
