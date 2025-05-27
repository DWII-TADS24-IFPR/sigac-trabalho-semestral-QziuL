<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\User;
use App\Repositories\AlunoRepository;
use App\Repositories\CursoRepository;
use App\Repositories\TurmaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AlunoController extends Controller
{
    private AlunoRepository $repository;
    private CursoRepository $cursoRepository;
    private TurmaRepository $turmaRepository;
    private array $regrasValidacao = [
        'name'      => 'required|string|min:4|max:255',
        'email'     => 'required|string|email|max:255|unique:users|unique:alunos',
        'cpf'       => 'required|string|min:11|max:11|unique:alunos',
        'password'  => 'min:6|string|max:255|confirmed',
        'turma'     => 'required',
        'curso'     => 'required',
    ];

    private array $mensagemErro = [
        'name.required' => 'O campo nome é obrigatório.',
        'email.required' => 'O campo email é obrigatório.',
        'cpf.required' => 'O campo cpf é obrigatório.',
        'password.required' => 'O campo senha é obrigatório',
    ];

    public function __construct()
    {
        $this->repository = new AlunoRepository();
        $this->cursoRepository = new CursoRepository();
        $this->turmaRepository = new TurmaRepository();
    }

    public function index(): View
    {
        // Se não tiver dados registrados, exibir na View dados nulos
        $alunos = $this->repository->selectAll();
        return view('aluno.index')->with('alunos', $alunos);
    }

    public function create()
    {
        $cursos = $this->cursoRepository->selectAll();
        $turmas = $this->turmaRepository->selectAll();
        return view('auth.register', compact('cursos', 'turmas'));
    }

    public function store(Request $request)
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $user = User::create([
            'name' => mb_strtoupper($request->get('name'), 'UTF-8'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        $aluno = new Aluno();
        $aluno->setNome($user->name);
        $aluno->setEmail($user->email);
        $aluno->setCpf($request->get('cpf'));
        $aluno->setSenha(bcrypt($request->get('password')));
        $aluno->setTurmaId(intval($request->get('turma')));
        $aluno->setCursoId(intval($request->get('curso')));
        $aluno->setUserId($user->id);
        $this->repository->save($aluno);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
        //return redirect()->route('aluno.index')->with(['success' => 'Aluno cadastrado com sucesso!']);
    }

    public function show(string $id)
    {
        $aluno = $this->find($id);
        return ($aluno)
            ?  view('aluno.show')->with('aluno', $aluno)
            :  view('aluno.index')->with('error', 'Aluno inexistente.');
    }

    public function edit(int $id)
    {
        $aluno = $this->find($id);
        $cursos = $this->cursoRepository->selectAll();
        $turmas = $this->turmaRepository->selectAll();
        return ($aluno)
            ? view('aluno.edit', compact('aluno', 'cursos', 'turmas'))
            : view('aluno.index')->with('error', 'Aluno inexistente.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $aluno = $this->find($id);
        if (isset($aluno)) {
            $aluno->setNome(mb_strtoupper($request->get('nome'), 'UTF-8'));
            $aluno->setEmail($request->get('email'));
            $aluno->setCpf($request->get('cpf'));
            $aluno->setCursoId(intval($request->get('curso')));
            $aluno->setTurmaId(intval($request->get('turma')));
            $aluno->update();
            return redirect()->route('aluno.index')->with('success', 'Aluno atualizado com sucesso!');
        }
        return view('aluno.index')->with('error', 'Aluno inexistente.');
    }

    public function destroy(int $id)
    {
        // REDIRECT FOR VIEW METHOD WITHOUT PARAMETER
        return ($this->find($id)->delete())
            ? redirect()->route('aluno.index')->with(['success' => 'Aluno removido com sucesso!'])
            : redirect()->route('aluno.index')->with(['error' => 'Aluno inexistente.']);
    }

    private function find(int $id)
    {
        return $this->repository->findById($id);
    }
}
