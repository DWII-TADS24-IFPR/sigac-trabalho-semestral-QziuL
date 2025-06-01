@extends('layouts.main')

@section('title', 'Editar Eixo')

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
                <h2>Editar Eixo</h2>
                <form method="post" action="{{ route('eixo.update', $eixo->id) }}"
                      onsubmit="return confirm('Tem certeza que deseja editar?');">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label class="form-label" for="nome">Nome: </label>
                        <input class="form-control" type="text" name="nome" value="{{ $eixo->nome }}" required>
                    </div>

                    <button class="btn btn-primary" type="submit">Atualizar</button>
                    <a class="btn btn-secondary"
                       href="{{route('eixo.index')}}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
