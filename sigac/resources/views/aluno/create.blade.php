@extends('layouts.main')

@section('title', 'Criar aluno')

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
                <h2>Cadastrar Aluno</h2>
                <form id="meuFormulario" action="{{ route('aluno.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Nome:</label>
                        <input class="form-control" type="text" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email:</label>
                        <input class="form-control" type="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cpf">CPF:</label>
                        <input class="form-control" type="text" name="cpf" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Senha:</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="curso">Selecione um curso...</label>
                        <select id="selectCurso" class="form-select mb-1" name="curso" required>
                            <option value="">-- Selecione um Curso --</option>
                            @foreach($cursos as $curso)
                                <option value="{{$curso->id}}">{{ $curso->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 hidden" id="selectTurmaContainer">
                        <label class="form-label" for="turma">Selecione uma turma...</label>
                        <select id="selectTurma" class="form-select mb-1" name="turma" required>

                        </select>
                        <div class="loader" id="turmaLoader"></div>
                    </div>
                    <button class="btn btn-primary" type="submit">Criar</button>
                    <a class="btn btn-secondary" href="{{route('aluno.index')}}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
