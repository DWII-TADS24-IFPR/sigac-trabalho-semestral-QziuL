@extends('layouts.main')

@section('title', 'Ver Aluno')

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
                <h2>Aluno(a): {{ $aluno->nome }}</h2>
                <div>
                    <p>E-mail: <b>{{ $aluno->email }}</b></p>
                    <p>CPF: <b>{{ $aluno->cpf }}</b></p>
                    <p>Curso: <b>{{ $aluno->curso->nome }}</b></p>
                    <p>Turma: <b>{{ $aluno->turma->ano }}</b></p>
                    <p>Horas registradas: <b>{{ $alunoHoras }}</b></p>

                    <button class="btn btn-primary mt-2">
                        <a href="{{ route('aluno.index') }} " class="text-decoration-none text-white">Voltar</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
