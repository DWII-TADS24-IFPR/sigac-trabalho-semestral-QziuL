@extends('layouts.main')

@section('title', 'Niveis')

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
                <h4 class="text-center bg-black text-white rounded-top-5 p-2">Niveis de Ensino</h4>
                <a class="text-center fs-5 link-underline-info" href="{{ route('nivel.create' )}}">
                    Cadastrar Nivel de Ensino
                </a>
                @if($niveis->isEmpty())
                    <p class="text-center fs-5 mt-3">Não há niveis de ensino cadastrados...</p>
                @else
                    <table class="table table-striped">

                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col" class="text-center">Ação</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($niveis as $nivel)
                            <tr>
                                <td>{{$nivel->nome}}</td>
                                <td>
                                    <div class="d-flex">
                                        <form method="get"
                                              class="d-inline m-0 p-0 mx-2"
                                              action="{{ route('nivel.edit', $nivel->id) }}" >
                                            @csrf
                                            <button class="btn mx-2 p-0" type="submit">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </button>
                                        </form>

                                        <form method="post" class="d-inline m-0 p-0"
                                              action="{{ route('nivel.destroy', $nivel->id) }}"
                                              onsubmit="return confirm('Tem certeza que deseja excluir?');" >
                                            @csrf
                                            @method('delete')
                                            <button class="btn m-0 p-0" type="submit">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </div>
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
