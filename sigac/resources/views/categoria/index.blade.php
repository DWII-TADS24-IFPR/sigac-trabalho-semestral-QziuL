@extends('layouts.main')

@section('title', 'Categorias')

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

    <div class="container-fluid px-4 row">
        <div class="col-xl vh-100">
            <div class="card p-4 border-light mb-3">
                <h4 class="text-center bg-black text-white rounded-top-5 p-2">Categorias Cadastradas</h4>
                <a class="text-center fs-5 link-underline-info" href="{{ route('categoria.create' )}}">
                    Cadastrar categoria
                </a>
                @if($categorias->isEmpty())
                    <p class="text-center fs-5 mt-3">Não há categorias cadastradas...</p>
                @else
                    <table class="table table-striped">

                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Máximo de horas</th>
                            <th scope="col">Curso</th>
                            <th scope="col" class="text-center">Ação</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($categorias as $categoria)
                            <tr>
                                <td>{{$categoria->nome}}</td>
                                <td>{{$categoria->maximo_horas}}</td>
                                <td>{{$categoria->curso->sigla}}</td>
                                <td class="d-flex justify-content-around">

                                    {{-- Editar categoria --}}
                                    <form method="get"
                                          class="d-inline m-0 p-0"
                                          action="{{ route('categoria.edit', $categoria->id) }}" >
                                        @csrf
                                        <button class="btn m-0 p-0" type="submit">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                    </form>

                                    {{-- Visualizar categoria --}}
                                    <form method="get"
                                          class="d-inline m-0 p-0"
                                          action="{{ route('categoria.show', $categoria->id) }}" >
                                        @csrf
                                        <button class="btn m-0 p-0" type="submit">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </form>

                                    {{-- Deletar categoria --}}
                                    <form method="post" class="d-inline m-0 p-0"
                                          action="{{ route('categoria.destroy', $categoria->id) }}"
                                          onsubmit="return confirm('Tem certeza que deseja excluir?');" >
                                        @csrf
                                        @method('delete')
                                        <button class="btn m-0 p-0" type="submit">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
@endsection
