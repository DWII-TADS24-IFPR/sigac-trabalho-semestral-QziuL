@extends('layouts.main')

@section('title', 'Solicitar horas')

@section('content')
    <div class="container-fluid px-4 mt-4 ">
        <div class="card">
            <div class="card-body">
                <h2>Solicitar horas complementares</h2>
                <form action="{{ route('documento.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div  class="mb-3">
                        <label class="form-label" for="descricao">Descrição</label>
                        <input class="form-control" type="text" name="descricao" id="descricao" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="horas_in">Horas solicitadas</label>
                        <input class="form-control" type="number" name="horas_in" id="horas_in" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="categoria_id">Vincule uma categoria...</label>
                        <select class="form-select mb-1" name="categoria_id" id="categoria_id" required>
                            @foreach($categorias as $categoria)
                                <option value="{{$categoria->id}}">{{ $categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"  for="documento">Certificado</label>
                        <input class="form-select mb-1" type="file" name="documento" id="documento" accept="application/pdf" required>
                    </div>

                    <button class="btn btn-primary" type="submit">Enviar</button>
                    <a class="btn btn-secondary" href="{{ route('documento.index') }}">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
