@extends('layouts.main')

@section('title', 'Editar aluno')

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
                <h2>Editar Aluno</h2>
                <form action="{{ route('aluno.update', $aluno->id) }}" method="post"
                      onsubmit="return confirm('Tem certeza que deseja editar?');">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label class="form-label" for="nome">Nome: </label>
                        <input class="form-control" type="text" name="nome" value="{{ $aluno->nome }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email:</label>
                        <input class="form-control" type="email" name="email" value="{{ $aluno->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cpf">CPF:</label>
                        <input class="form-control" type="text" name="cpf" value="{{ $aluno->cpf }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="curso">Selecione um curso...</label>
                        <select class="form-select mb-1" name="curso" required>
                            @foreach($cursos as $curso)
                                <option value="{{$curso->id}}" {{ $aluno->curso->nome == $curso->nome ? 'selected' : ''}}>
                                    {{ $curso->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="turma">Selecione uma turma...</label>
                        <select class="form-select mb-1" name="turma" required>
                            @foreach($turmas as $turma)
                                <option value="{{$turma->id}}" {{ $aluno->turma->ano == $turma->ano  ? 'selected' : '' }}>
                                    {{ $turma->ano }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Atualizar</button>
                    <a class="btn btn-danger mt-2 text-decoration-none text-white"
                       href="{{route('aluno.index')}}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
