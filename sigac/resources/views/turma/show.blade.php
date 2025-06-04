@extends('layouts.main')

@section('title', 'Ver Turma')

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
                <h2>Turma: {{ $turma->ano }}</h2>
                <div class="mt-4">
                    <h4>Curso vinculado:</h4>
                    <ul>
                        @if(isset($turma->curso))
                            <li><a class="text-decoration-none" href="{{ route('curso.show', $turma->curso->id) }}"><b>{{ $turma->curso->nome }}</b></a></li>
                        @else
                            <li><b>Nenhum curso vinculado.</b></li>
                        @endif
                    </ul>
                    <h4>Alunos vinculados:</h4>
                    <ul>
                        @if(sizeof($turma->curso->alunos))
                            @foreach($turma->curso->alunos as $aluno)
                                @if($aluno->turma->ano == $turma->ano)
                                    <li><a class="text-decoration-none" href="{{ route('aluno.show', $aluno->id) }}">{{ $aluno->nome }}</a></li>
                                @else
                                    <li><b>Nenhum aluno vinculado.</b></li>
                                @endif
                            @endforeach
                        @else
                            <li><b>Nenhum aluno vinculado.</b></li>
                        @endif
                    </ul>

                    <button class="btn btn-secondary mt-2">
                        <a href="{{ route('turma.index') }} " class="text-decoration-none text-white">Voltar</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
