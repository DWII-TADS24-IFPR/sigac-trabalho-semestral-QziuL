@extends('layouts.main')

@section('title', 'Ver Curso')

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
                <h2>Curso: {{ $curso->nome }}</h2>
                <div>
                    <p>Sigla: <b>{{ $curso->sigla }}</b></p>
                    <p>Total de horas: <b>{{ $curso->total_horas }}</b></p>
                    <p>Nível: <b>{{ $curso->nivel->nome }}</b></p>
                    <p>Eixo: <b>{{ $curso->eixo->nome }}</b></p>
                    <p>Turmas vinculadas: <b>{{ sizeof($curso->turmas) }}</b></p>
                    <p>Alunos vinculados: <b>{{ sizeof($curso->alunos) }}</b></p>

                    <button class="btn btn-secondary mt-2">
                        <a href="{{ route('curso.index') }} " class="text-decoration-none text-white">Voltar</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
