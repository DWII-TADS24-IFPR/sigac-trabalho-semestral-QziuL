@extends('layouts.main')

@section('title', 'Editar solicitação')

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

    <div class="container-fluid px-4 mt-4">
        <div class="card">
            <div class="card-body">
                <h4>Editar Documento {{ $documento->id }}</h4>
                <form action="{{ route('documento.update', $documento->id) }}"
                      method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label class="form-label" for="descricao">Descrição</label>
                        <input class="form-control" type="text" name="descricao" id="descricao" value="{{ $documento->descricao }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="horas_in">Horas solicitadas</label>
                        <input class="form-control" type="number" name="horas_in" id="horas_in" value="{{ $documento->horas_in }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="categoria_id">Categoria</label>
                        <select class="form-select mb-1"
                                name="categoria_id" id="categoria_id" required>
                            @foreach($categorias as $categoria)
                                <option value="{{$categoria->id}}"
                                    {{ ($documento->categoria->id == $categoria->id) ? 'selected' : '' }}>
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="documento">Certificado</label>
                        <input class="form-control" type="file" name="documento" id="documento" required>
                    </div>
                    <div>
                        <button class="btn btn-primary mt-4" type="submit">Atualizar</button>
                        <a class="btn btn-secondary mt-4"
                           href="{{ route('documento.index') }}">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
