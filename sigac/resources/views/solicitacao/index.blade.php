@extends('layouts.main')

@section('title', 'Solicitações')


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
                <h4 class="text-center bg-black text-white rounded-top-5 p-2">Solicitações pendentes de aprovação</h4>
                @if($documentos->isEmpty())
                    <p class="text-center fs-5 mt-3">Sem solicitações de horas complementares...</p>
                @else
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Horas</th>
                            <th scope="col">Aluno</th>
                            <th scope="col" class="text-center">Ação</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($documentos as $documento)
                            @if(!$documento->status)
                                <tr>
                                    <td>{{$documento->id}}</td>
                                    <td>{{$documento->descricao}}</td>
                                    <td>{{$documento->horas_in}}</td>
                                    <td>{{($documento->user->nome)}}</td>
                                    <td class="flex content-around ml-4">
                                        <form method="post" class="d-inline m-0 p-0"
                                              action="{{ route('solicitacao.refused', $documento->id) }}" >
                                            @csrf

                                            <button class="btn m-0 p-0" type="submit">
                                                <i class="fa-solid fa-ban" style="color: #000000;"></i>
                                            </button>
                                        </form>

                                        <form method="post" class="d-inline m-0 p-0"
                                              action="{{ route('solicitacao.approved', $documento->id) }}">
                                            @csrf

                                            <button class="btn m-0 p-0" type="submit">
                                                <i class="fa-solid fa-thumbs-up" style="color: #000000;"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
