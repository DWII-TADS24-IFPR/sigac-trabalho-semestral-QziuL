@extends('layouts.main')

@section('title', 'Editar nivel')

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
                <h2>Editar Nivel de Ensino</h2>
                <form action="{{ route('nivel.update', $nivel->id) }}" method="post"
                      onsubmit="return confirm('Tem certeza que deseja editar?');">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label class="form-label" for="nome">Nome: </label>
                        <input class="form-control" type="text" name="nome" value="{{ $nivel->nome }}" required>
                    </div>

                    <button class="btn btn-primary" type="submit">Atualizar</button>
                    <a class="btn btn-secondary"
                       href="{{route('nivel.index')}}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
