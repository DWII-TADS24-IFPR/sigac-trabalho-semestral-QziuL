@extends('layouts.main')

@section('title', 'Criar comprovante')

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
                <h2>Cadastrar Comprovante</h2>
                <form action="{{ route('comprovante.store') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="horas">Horas: </label>
                        <input class="form-control" type="text" name="horas" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="atividade">Atividade:</label>
                        <input class="form-control" type="text" name="atividade" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="categoria_id">Vincule uma categoria...</label>
                        <select class="form-select mb-1" name="categoria_id" required>
                            @foreach($categorias as $categoria)
                                <option value="{{$categoria->id}}">
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="aluno_id">Vincule um aluno...</label>
                        <select class="form-select mb-1" name="aluno_id" required>
                            @foreach($alunos as $aluno)
                                <option value="{{$aluno->id}}">
                                    {{ $aluno->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-primary" type="submit">Cadastrar</button>
                    <a class="btn btn-danger mt-2 text-decoration-none text-white"
                       href="{{route('comprovante.index')}}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
