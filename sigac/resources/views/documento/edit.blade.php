@extends('layouts.main')

@section('title', 'Editar solicitação')

@section('content')
    <div>
        <form action="{{ route('documento.update', $documento->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div>
                <label for="descricao">Descrição</label>
                <input type="text" name="descricao" id="descricao" value="{{ $documento->descricao }}" required>
            </div>
            <div>
                <label for="horas_in">Horas solicitadas</label>
                <input type="number" name="horas_in" id="horas_in" value="{{ $documento->horas_in }}" required>
            </div>
            <div>
                <x-input-label for="categoria_id" :value="__('Categoria')" />
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="categoria_id" id="categoria_id" required>
                    @foreach($categorias as $categoria)
                        <option value="{{$categoria->id}}"
                            {{ ($documento->categoria->id == $categoria->id) ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="documento">Certificado</label>
                <input type="file" name="documento" id="documento" required>
            </div>
            <div>
                <x-primary-button class="ms-4">
                    {{ __('Enviar') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
