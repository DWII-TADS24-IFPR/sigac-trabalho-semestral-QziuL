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
                <form action="{{ route('aluno.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="nome">Nome:</label>
                        <input class="form-control" type="text" name="nome" required>
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
                        <label class="form-label" for="senha">Senha:</label>
                        <input class="form-control" type="password" name="senha" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="curso">Selecione um curso...</label>
                        <select class="form-select mb-1" name="curso" required>
                            @foreach($cursos as $curso)
                                <option value="{{$curso->id}}">{{ $curso->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="turma">Selecione uma turma...</label>
                        <select class="form-select mb-1" name="turma" required>
                            @foreach($turmas as $turma)
                                <option value="{{$turma->id}}">{{ $turma->ano }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Criar</button>
                    <a class="btn btn-danger mt-2 text-decoration-none text-white" href="{{route('aluno.index')}}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
