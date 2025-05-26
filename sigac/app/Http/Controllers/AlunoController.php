<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\User;
use App\Repositories\AlunoRepository;
use App\Repositories\CursoRepository;
use App\Repositories\TurmaRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function PHPUnit\Framework\isEmpty;

class AlunoController extends Controller
{
    private AlunoRepository $repository;
    private CursoRepository $cursoRepository;
    private TurmaRepository $turmaRepository;
    private array $regrasValidacao = [
        'nome'      => 'required|min:4|max:255',
        'email'     => 'required|email|max:255',
        'cpf'       => 'required|min:11|max:11',
        'senha'     => 'min:6|max:100',
        'turma'     => 'required',
        'curso'     => 'required',
    ];

    private array $mensagemErro = [
        'nome.required' => 'O campo nome é obrigatório.',
        'email.required' => 'O campo email é obrigatório.',
        'cpf.required' => 'O campo cpf é obrigatório.',
        'senha.required' => 'O campo senha é obrigatório',
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
        return view('aluno.create', compact('cursos', 'turmas'));
    }

    public function store(Request $request)
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $aluno = new Aluno();
        $aluno->setNome(mb_strtoupper($request->get('nome'), 'UTF-8'));
        $aluno->setEmail($request->get('email'));
        $aluno->setCpf($request->get('cpf'));
        $aluno->setSenha(bcrypt($request->get('senha')));
        $aluno->setTurmaId(intval($request->get('turma')));
        $aluno->setCursoId(intval($request->get('curso')));
        $this->repository->save($aluno);

        return redirect()->route('aluno.index')->with(['success' => 'Aluno cadastrado com sucesso!']);
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
//            $aluno->update($request->all());
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
