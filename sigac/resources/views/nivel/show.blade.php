@extends('layouts.main')

@section('title', 'Ver Nivel')

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
                <h2>Nível: {{ $nivel->nome }}</h2>
                <div class="mt-4">
                    <h4>Cursos vinculados</h4>
                    <ul>
                    @if(sizeof($nivel->cursos) > 0)
                        @foreach($nivel->cursos as $curso)
                            <li><a class="text-decoration-none" href="{{ route('curso.show', $curso->id) }}"><b>{{ $curso->nome }}</b></a></li>
                        @endforeach
                    @else
                        <li><b>Nenhum curso vinculado.</b></li>
                    @endif
                    </ul>

                    <button class="btn btn-secondary mt-2">
                        <a href="{{ route('nivel.index') }} " class="text-decoration-none text-white">Voltar</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
