@extends('layouts.main')

@section('title', 'Solicitação recusada')

@section('content')
    <div class="container-fluid px-4 mt-4 ">
        <div class="card">
            <div class="card-body">
                <h2>Razão para recusar solicitação de horas</h2>
                <form action="{{ route('solicitacao.refusedStore', $documento->id) }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="comentario">Comentário</label>
                        <input class="form-control" type="text" name="comentario" required>
                    </div>

                    <button class="btn btn-primary" type="submit">Criar</button>
                    <a class="btn btn-danger mt-2 text-decoration-none text-white" href="{{ route('solicitacao.index') }}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
