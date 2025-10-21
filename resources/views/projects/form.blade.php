@php
    $selected = old('members', isset($project) ? $project->members->pluck('user_id')->toArray() : []);
@endphp
@csrf
<div class="space-y-4">
    <div>
        <label class="block font-medium">Título</label>
        <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" class="w-full border p-2 rounded">
        @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block font-medium">Descrição</label>
        <textarea name="description" class="w-full border p-2 rounded">{{ old('description', $project->description ?? '') }}</textarea>
    </div>

    <div class="flex space-x-4">
        <div class="flex-1">
            <label class="block font-medium">Data Início</label>
            <input type="date" name="start_date" value="{{ old('start_date', $project->start_date ?? '') }}" class="w-full border p-2 rounded">
        </div>
        <div class="flex-1">
            <label class="block font-medium">Data Conclusão</label>
            <input type="date" name="end_date" value="{{ old('end_date', $project->end_date ?? '') }}" class="w-full border p-2 rounded">
        </div>
    </div>

    <div>
        <label class="block font-medium">Arquivo (PDF/Imagem)</label>
        <input type="file" name="attachment" class="w-full border p-2 rounded">
        @if(!empty($project->attachment))
            <p class="text-sm mt-1">Arquivo atual:
                <a href="{{ asset('storage/'.$project->attachment) }}" target="_blank" class="text-blue-600 underline">Ver arquivo</a>
            </p>
        @endif
    </div>

    <div>
        <label class="block font-medium">Membros do Projeto</label>
        <select name="members[]" multiple class="w-full border p-2 rounded">
            @foreach($users as $user)
                <option value="{{ $user->id }}"
                    @if(in_array($user->id, (array) $selected)) selected @endif>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('members') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
</div>
