@extends('layouts.main')

@section('title', 'Editar categoria')

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
                <h2>Editar Categoria</h2>
                <form action="{{ route('categoria.update', $categoria->id) }}" method="post"
                      onsubmit="return confirm('Tem certeza que deseja editar?');">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label class="form-label" for="nome">Nome:</label>
                        <input class="form-control" type="text" name="nome" value="{{ $categoria->nome }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="maximo_horas">Máximo horas:</label>
                        <input class="form-control" type="number" name="maximo_horas" value="{{ $categoria->maximo_horas }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="curso_id">Selecione um curso...</label>
                        <select class="form-select mb-1" name="curso_id" required>
                            @foreach($cursos as $curso)
                                <option value="{{$curso->id}}" {{ $categoria->curso->nome == $curso->nome ? 'selected' : '' }}>
                                    {{ $curso->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Editar</button>
                    <a class="btn btn-danger mt-2 text-decoration-none text-white"
                       href="{{route('categoria.index')}}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
