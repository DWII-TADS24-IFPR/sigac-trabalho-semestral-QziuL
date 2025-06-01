@extends('layouts.main')

@section('title', 'Documentos')


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
                <h4 class="text-center bg-black text-white rounded-top-5 p-2">Solicitações feitas</h4>
                <a class="text-center fs-5 link-underline-info" href="{{ route('documento.create' )}}">
                    Solicitar horas complementares
                </a>
                @if($documentos->isEmpty())
                    <p class="text-center fs-5 mt-3">Sem solicitações de horas complementares...</p>
                @else
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Horas</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Ação</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($documentos as $documento)
                            <tr>
                                <td>{{$documento->id}}</td>
                                <td>{{$documento->descricao}}</td>
                                <td>{{$documento->horas_in}}</td>
                                <td>{{($documento->status) ? 'Aprovado' : 'Pendente'}}</td>
                                <td class="d-flex justify-content-around ml-4">
                                    {{-- Ver documento --}}
                                    <form method="get"
                                          class="d-inline m-0 p-0"
                                          action="{{ route('documento.show', $documento->id) }}" >
                                        @csrf
                                        <button class="btn m-0 p-0" type="submit">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                    {{-- Editar documento --}}
                                    <form method="get"
                                          class="d-inline m-0 p-0"
                                          action="{{ route('documento.edit', $documento->id) }}" >
                                        @csrf
                                        <button class="btn m-0 p-0" type="submit">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                    {{-- Deletar documento --}}
                                    <form method="post" class="d-inline m-0 p-0"
                                          action="{{ route('documento.destroy', $documento->id) }}"
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
