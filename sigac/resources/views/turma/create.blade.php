@extends('layouts.main')

@section('title', 'Criar turma')

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
                <h2>Cadastrar Turma</h2>
                <form action="{{ route('turma.store') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="ano">Ano:</label>
                        <input class="form-control" type="number" name="ano" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="curso">Selecione um curso...</label>
                        <select class="form-select mb-1" name="curso" required>
                            @foreach($cursos as $curso)
                                <option value="{{$curso->id}}">{{ $curso->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-primary" type="submit">Criar</button>
                    <a class="btn btn-danger mt-2 text-decoration-none text-white" href="{{ route('turma.index') }}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
