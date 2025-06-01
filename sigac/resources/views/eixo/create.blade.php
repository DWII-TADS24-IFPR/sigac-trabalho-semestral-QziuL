@extends('layouts.main')

@section('title', 'Criar Eixo')

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

    <div class="container-fluid px-4 mt-4 ">
        <div class="card">
            <div class="card-body">
                <h2>Cadastrar Eixo</h2>
                <form action="{{ route('eixo.store') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="nome">Nome:</label>
                        <input class="form-control" type="text" name="nome" required>
                    </div>

                    <button class="btn btn-primary" type="submit">Criar</button>
                    <a class="btn btn-secondary" href="{{route('eixo.index')}}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
