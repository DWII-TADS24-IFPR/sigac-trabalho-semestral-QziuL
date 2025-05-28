@extends('layouts.main')

@section('title', 'Comprovantes')

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
                <h4 class="text-center bg-black text-white rounded-top-5 p-2">Comprovantes</h4>
                <a class="text-center fs-5 link-underline-info" href="{{ route('comprovante.create' )}}">
                    Cadastrar comprovante
                </a>
                @if($comprovantes->isEmpty())
                    <p class="text-center fs-5 mt-3">Não há comprovantes cadastrados...</p>
                @else
                    <table class="table table-striped">

                        <thead>
                        <tr>
                            <th scope="col">Horas</th>
                            <th scope="col">Atividade</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Aluno</th>
                            <th scope="col" class="text-center">Ação</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($comprovantes as $comprovante)
                            <tr>
                                <td>{{$comprovante->horas}}</td>
                                <td>{{$comprovante->atividade}}</td>
                                <td>{{$comprovante->categoria->nome}}</td>
                                <td>{{$comprovante->aluno->email}}</td>
                                <td class="d-flex justify-content-around">
                                    <form method="get"
                                          class="d-inline m-0 p-0"
                                          action="{{ route('comprovante.edit', $comprovante->id) }}" >
                                        @csrf

                                        <button class="btn m-0 p-0" type="submit">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                    </form>

                                    <form method="post" class="d-inline m-0 p-0"
                                          action="{{ route('comprovante.destroy', $comprovante->id) }}"
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
