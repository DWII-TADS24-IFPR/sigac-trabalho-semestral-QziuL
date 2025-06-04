<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-2">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-2">
            <x-input-label for="cpf" :value="__('CPF')" />
            <x-text-input id="cpf" class="block mt-1 w-full" type="text" name="cpf" :value="old('cpf')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-2">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-2">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-2">
            <x-input-label for="curso" :value="__('Seu curso')" />
            <select id="selectCurso" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="curso" required>
                <option value="">-- Selecione um Curso --</option>
                @foreach($cursos as $curso)
                    <option value="{{$curso->id}}">{{ $curso->nome }}</option>
                @endforeach
            </select>

            <div class="hidden" id="selectTurmaContainer">
                <x-input-label for="turma" :value="__('Sua turma')" />
                <select id="selectTurma" class="fbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"" name="turma" required>

                </select>
                <div class="loader" id="turmaLoader"></div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Possui cadastro?') }}
            </a>

            <form method="post" action="{{ route('aluno.store') }}">
                @csrf
                <button class="btn btn-primary">
                    Cadastrar
                </button>
            </form>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {


            const selectCurso = document.getElementById('selectCurso');
            const selectTurma = document.getElementById('selectTurma');
            const selectTurmaContainer = document.getElementById('selectTurmaContainer');
            const turmaLoader = document.getElementById('turmaLoader'); // Pega o loader

            console.log('Elemento selectTurmaContainer:', selectTurmaContainer);
            console.log('Elemento selectCurso:', selectCurso);
            console.log('Elemento selectTurma:', selectTurma);

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
</x-guest-layout>
{{-- Script para cadastro de aluno --}}


