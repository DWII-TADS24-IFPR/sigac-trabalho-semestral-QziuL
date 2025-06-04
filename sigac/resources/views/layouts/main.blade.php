<!DOCTYPE html>
<html lang="pt-br">
<head>
    @vite(['resources/js/app.js'])
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title', 'Dashboard - SIGAC Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            color: white;
            padding: 1rem;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 0.5rem 0;
        }
        .sidebar a:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .main-content {
            margin-left: 220px;
            padding: 2rem;
        }

        #selectTurmaContainer.hidden {
            display: none;
        }
        .loader { /* Estilo simples para um indicador de carregamento */
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid #3498db;
            width: 20px;
            height: 20px;
            animation: spin 2s linear infinite;
            display: none; /* Começa oculto */
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="sb-nav-fixed">
<div class="sidebar">
    <div>
        <h4><a href="{{ route('home') }}">SIGAC</a></h4>
        <p>Olá, {{ auth()->user()->name }}!</p>
    </div>

    @auth
        @if(auth()->user()->is_admin)
            <a href="{{route('aluno.index')}}">Aluno</a>
            <a href="{{ route('categoria.index') }}">Categorias</a>
            <a href="{{ route('curso.index') }}">Cursos</a>
            <a href="{{ route('nivel.index') }}">Niveis</a>
            <a href="{{ route('turma.index') }}">Turmas</a>
            <a href="{{ route('eixo.index') }}">Eixos</a>
{{--            <a href="{{ route('comprovante.index') }}">Comprovantes</a>--}}
            <a href="{{ route('solicitacao.index') }}">Solicitações</a>
        @endif
        @if(!auth()->user()->is_admin)
            <a class="inline-block w-full px-4 py-2" href="{{ route('documento.index') }}">Horas Complementares</a>
            <a class="inline-block w-full px-4 py-2" href="{{ route('declaracao.index') }}">Declarações</a>
        @endif

        <form method="POST" action="{{ route('logout') }}"
              onsubmit="return confirm('Deseja realmete sair?');" >
            @csrf

            <button class="btn" type="submit">
                <a class="inline-block w-full px-4 py-2">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Sair
                </a>
            </button>
        </form>
    @endauth

</div>

<div class="main-content">
    @yield('content')
</div>

<footer>
    <div class="">
        <p class="text-center">SIGAC - Sistema de Gerenciamento de Atividades Complementares</p>
        <p class="text-center">Todos os direitos reservados &copy; {{ date('Y') }}</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
{{-- Script para cadastro de aluno --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectCurso = document.getElementById('selectCurso');
        const selectTurma = document.getElementById('selectTurma');
        const selectTurmaContainer = document.getElementById('selectTurmaContainer');
        const turmaLoader = document.getElementById('turmaLoader'); // Pega o loader

        selectCurso.addEventListener('change', function() {
            const cursoId = this.value;

            // Limpa select de turmas e o oculta enquanto carrega
            selectTurma.innerHTML = '<option value="">-- Carregando turmas... --</option>';
            if (!cursoId) { // Se "-- Selecione um Curso --" for escolhido
                selectTurmaContainer.classList.add('hidden');
                selectTurma.innerHTML = '<option value="">-- Selecione uma Turma --</option>';
                return;
            }

            // Mostra o container e o loader
            selectTurmaContainer.classList.remove('hidden');
            turmaLoader.style.display = 'inline-block'; // Mostra o loader
            selectTurma.disabled = true; // Desabilita o select enquanto carrega

            // Monta a URL para a requisição AJAX usando a rota nomeada do Laravel
            // A função 'route()' do Ziggy.js é uma boa opção se você usar,
            // caso contrário, construa a URL manualmente ou passe-a via PHP.
            // Para este exemplo, vamos construir manualmente (mas tenha cuidado com a baseURL):
            // const url = `/buscar-turmas/${cursoId}`; // Simples, mas pode não ser ideal em subdiretórios

            // Forma mais robusta de pegar a URL base caso não use Ziggy:
            const baseUrl = "{{ url('/') }}"; // Pega a URL base da aplicação
            const url = `${baseUrl}/buscar-turmas/${cursoId}`;

            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest', // Útil para o Laravel identificar como AJAX
                    // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Não é necessário para GET, mas bom saber
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na rede ou resposta não OK: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    selectTurma.innerHTML = '<option value="">-- Selecione uma Turma --</option>'; // Placeholder

                    if (data && data.length > 0) {
                        data.forEach(function(turma) {
                            const option = document.createElement('option');
                            option.value = turma.id; // Usando o ID da turma como valor
                            option.textContent = turma.nome; // Usando o nome da turma como texto
                            selectTurma.appendChild(option);
                        });
                    } else if (data.error) {
                        console.error('Erro do servidor:', data.error);
                        selectTurma.innerHTML = '<option value="">-- Erro ao carregar turmas --</option>';
                    }
                    else {
                        selectTurma.innerHTML = '<option value="">-- Nenhuma turma encontrada --</option>';
                    }
                })
                .catch(error => {
                    console.error('Erro na requisição AJAX:', error);
                    selectTurma.innerHTML = '<option value="">-- Falha ao buscar turmas --</option>';
                    // Poderia adicionar uma mensagem de erro mais visível para o usuário aqui
                })
                .finally(() => {
                    turmaLoader.style.display = 'none'; // Esconde o loader
                    selectTurma.disabled = false; // Reabilita o select
                });
        });
    });
</script>
</body>
</html>
