@extends('layouts.main')

@section('title', 'Editar turma')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="container-fluid px-4 mt-4 ">
        <div class="card">
            <div class="card-body">
                <h2>Editar Turma</h2>
                <form action="{{ route('turma.update', $turma->id) }}" method="post"
                      onsubmit="return confirm('Tem certeza que deseja editar?');">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label class="form-label" for="ano">Ano:</label>
                        <input class="form-control" type="number" name="ano" value="{{ $turma->ano }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="curso">Selecione um curso...</label>
                        <select class="form-select mb-1" name="curso" required>
                            @foreach($cursos as $curso)
                                <option value="{{$curso->id}}" {{ $turma->curso->nome == $curso->nome ? 'selected' : ''}}>
                                    {{ $curso->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-primary" type="submit">Atualizar</button>
                    <a class="btn btn-danger mt-2 text-decoration-none text-white"
                       href="{{route('turma.index')}}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
