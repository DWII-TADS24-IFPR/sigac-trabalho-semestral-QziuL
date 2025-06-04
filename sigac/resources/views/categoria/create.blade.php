@extends('layouts.main')

@section('title', 'Criar categoria')

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

    <div class="container-fluid px-4 mt-4 ">
        <div class="card">
            <div class="card-body">
                <h2>Cadastrar Categoria</h2>
                <form action="{{ route('categoria.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="nome">Nome:</label>
                        <input class="form-control" type="text" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="maximo_horas">Máximo horas:</label>
                        <input class="form-control" type="number" name="maximo_horas" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="curso_id">Selecione um curso...</label>
                        <select class="form-select mb-1" name="curso_id" required>
                            @foreach($cursos as $curso)
                                <option value="{{$curso->id}}">{{ $curso->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Criar</button>
                    <a class="btn btn-secondary"
                       href="{{route('categoria.index')}}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
