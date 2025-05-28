@extends('layouts.main')

@section('title', 'Criar curso')

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
                <h2>Cadastrar Curso</h2>
                <form action="{{ route('curso.store') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="nome">Nome: </label>
                        <input class="form-control" type="text" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="sigla">Sigla:</label>
                        <input class="form-control" type="text" name="sigla" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="horas">Total de horas:</label>
                        <input class="form-control" type="number" name="total_horas" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nivel_id">Selecione o Nivel</label>
                        <select class="form-select mb-1" name="nivel_id" required>
                            @foreach($niveis as $nivel)
                                <option value="{{$nivel->id}}">
                                    {{ $nivel->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="eixo_id">Selecione o Eixo</label>
                        <select class="form-select mb-1" name="eixo_id" required>
                            @foreach($eixos as $eixo)
                                <option value="{{$eixo->id}}">
                                    {{ $eixo->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Criar</button>
                    <a class="btn btn-danger mt-2 text-decoration-none text-white" href="{{ route('curso.index') }}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
