@extends('layouts.main')

@section('title', 'Declarações')

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
                <h4 class="text-center bg-black text-white rounded-top-5 p-2">Declarações</h4>

                <div class="card-body">
                    @if($cursoConcluido)
                        <div class="text-center">
                            <h4>Parabéns, {{ $aluno->nome }}! </h4>
                            <h4>Você alcançou as horas necessárias para formação do seu curso.</h4>
                            <p>Horas necessárias: {{$cursoHoras}} horas</p>
                            <p>Horas registradas: {{$alunoHoras}} horas</p>
                            <form method="post" action="{{ route('declaracao.store') }}">
                                @csrf

                                <input hidden name="aluno-email" value="{{auth()->user()->email}}">
                                <input hidden name="aluno-horas" value="{{$alunoHoras}}">

                                <button class="btn btn-primary text-white">
                                    Gerar declaração
                                </button>
                            </form>
                        </div>
                    @else
                        <h2>Você não pode gerar sua declaração.</h2>
                        <p>Aluno: {{ $aluno->nome }}</p>
                        <p>Curso: {{ $aluno->curso->nome }}</p>
                        <p>Horas registradas: {{ $alunoHoras }}</p>
                        <p>Horas necessárias: {{ $cursoHoras }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
