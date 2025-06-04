@extends('layouts.main')

@section('title', 'Solicitações')

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
                <h2>Solicitação nº {{ $solicitacao->id }}</h2>
                <div class="mt-4">
                    <p>Enviado pelo aluno(a): {{ $solicitacao->user->name }} - {{ $solicitacao->user->aluno }}</p>
                    <p>Descrição: <b>{{ $solicitacao->descricao }}</b></p>
                    <p>Categoria: <b>{{ $solicitacao->categoria->nome }}</b></p>
                    <p>Horas solicitadas: <b>{{ $solicitacao->horas_in }} horas</b></p>
                    <p>
                        @if($solicitacao->statuso == 0)
                            Status: <b>PENDENTE</b>
                        @else
                            Status: <b>APROVADO</b>
                        @endif
                    </p>

                    <button class="btn btn-primary mt-2">
                        {{-- helper "url()" para acessar url base da aplicação (http://locahost:8000) --}}
                        <a href="{{ url("storage/" . $solicitacao->url) }}" class="text-decoration-none text-white">
                            Visualizar documento
                        </a>
                    </button>
{{--                    <div class="mt-2">--}}
{{--                        @if(isset($documenot->comentario))--}}
{{--                            <p>Comentário do admin: <b>{{ $solicitacao->comentario }}</b></p>--}}
{{--                        @else--}}
{{--                            <label class="form-label" for="comentario">Deseja adicionar um comentario?</label>--}}
{{--                            <input class="form-control" name="comentario" id="comentario">--}}
{{--                        @endif--}}
{{--                    </div>--}}
                    <button class="btn btn-secondary mt-2">
                        <a href="{{ route('solicitacao.index') }} " class="text-decoration-none text-white">Voltar</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
