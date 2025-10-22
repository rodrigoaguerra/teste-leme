<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nova Tarefa') }}
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
                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                        @include('tasks.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
