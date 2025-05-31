@extends('layouts.main')

@section('title', 'Ver documento')

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
                <h2>Solicitação nº {{ $documento->id }}</h2>
                <div>
                    <p>Descrição: <b>{{ $documento->descricao }}</b></p>
                    <p>Categoria: <b>{{ $documento->categoria->nome }}</b></p>
                    <p>Horas solicitadas: <b>{{ $documento->horas_in }} horas</b></p>
                    @if(isset($documenot->comentario))
                        <p>Comentário do admin: <b>{{ $documento->comentario }}</b></p>
                    @endif
                    <p>
                        @if($documento->statuso == 0)
                            Status: <b>PENDENTE</b>
                        @else
                            Status: <b>APROVADO</b>
                       @endif
                    </p>

                    <button class="btn btn-primary mt-2">
                        {{-- helper "url()" para acessar url base da aplicação (http://locahost:8000) --}}
                        <a href="{{ url("storage/" . $documento->url) }}" class="text-decoration-none text-white">
                            Visualizar documento
                        </a>
                    </button>
                    <button class="btn btn-secondary mt-2">
                        <a href="{{ route('documento.index') }} " class="text-decoration-none text-white">Voltar</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
