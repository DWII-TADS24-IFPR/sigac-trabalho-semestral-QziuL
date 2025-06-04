@extends('layouts.main')

@section('title', 'Cursos')

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
                <h4 class="text-center bg-black text-white rounded-top-5 p-2">Cursos Cadastrados</h4>
                <a class="text-center fs-5 link-underline-info" href="{{ route('curso.create' )}}">
                    Cadastrar Curso
                </a>
                @if($cursos->isEmpty())
                    <p class="text-center fs-5 mt-3">Não há cursos cadastrados...</p>
                @else
                    <table class="table table-striped table-responsive">

                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col" class="w-50">Nome</th>
                            <th scope="col">Sigla</th>
{{--                            <th scope="col">Horas</th>--}}
                            <th scope="col">Nível</th>
{{--                            <th scope="col">Eixo</th>--}}
                            <th scope="col" class="text-center">Ação</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($cursos as $curso)
                            <tr>
                                <td>{{$curso->id}}</td>
                                <td>{{$curso->nome}}</td>
                                <td>{{$curso->sigla}}</td>
{{--                                <td>{{$curso->total_horas}}</td>--}}
                                <td>{{$curso->nivel->nome}}</td>
{{--                                <td>{{$curso->eixo->nome}}</td>--}}
                                <td class="d-flex justify-content-around py-4">
                                    {{-- Editar curso --}}
                                    <form method="get"
                                          class="d-inline m-0 p-0"
                                          action="{{ route('curso.edit', $curso->id) }}" >
                                        @csrf
                                        <button class="btn m-0 p-0" type="submit">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                    {{-- Visualizar curso --}}
                                    <form method="get"
                                          class="d-inline m-0 p-0"
                                          action="{{ route('curso.show', $curso->id) }}" >
                                        @csrf
                                        <button class="btn m-0 p-0" type="submit">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                    {{-- Deletar curso --}}
                                    <form method="post" class="d-inline m-0 p-0"
                                          action="{{ route('curso.destroy', $curso->id) }}"
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
