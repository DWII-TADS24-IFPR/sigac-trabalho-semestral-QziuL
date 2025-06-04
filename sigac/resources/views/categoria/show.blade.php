@extends('layouts.main')

@section('title', 'Ver Categoria')

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
                <h2>Categoria: {{ $categoria->nome }}</h2>
                <div>
                    <p>Máximo de horas: <b>{{ $categoria->maximo_horas }}</b></p>
                    <p>Curso vinculado: <b>{{ $categoria->curso->nome }}</b></p>

                    <button class="btn btn-primary mt-2">
                        <a href="{{ route('categoria.index') }} " class="text-decoration-none text-white">Voltar</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
