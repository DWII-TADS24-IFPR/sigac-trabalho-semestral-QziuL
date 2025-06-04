<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Repositories\CursoRepository;
use App\Repositories\TurmaRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TurmaController extends Controller
{
    private TurmaRepository $repository;
    private CursoRepository $cursoRepository;

    private array $regrasValidacao = [
        'ano'      => 'required|integer',
        'curso_id'     => 'required',
    ];

    private array $mensagemErro = [
        'ano.required' => 'O campo ano é obrigatório.',
        'curso_id.required' => 'O campo curso é obrigatório.',
    ];

    public function __construct()
    {
        $this->repository = new TurmaRepository();
        $this->cursoRepository = new CursoRepository();
    }

    public function index(): View
    {
        $turmas = $this->repository->selectAll();
        return view('turma.index', compact('turmas'));
    }

    public function create(): View
    {
        $cursos = $this->cursoRepository->selectAll();
        return view('turma.create', compact('cursos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $turma = new Turma();
        $turma->setAno($request->get('ano'));
        $turma->setCursoId(intval($request->get('curso_id')));
        $turma->save();

        return redirect()->route('turma.index')->with('sucess', 'Turma criada com sucesso.');
    }

    public function show(string $id): View | RedirectResponse
    {
        $turma = $this->repository->findById(intval($id));
//        dd($turma->curso->alunos);
        return ($turma)
            ? view('turma.show', compact('turma'))
            : redirect()->route('turma.index')->with('error', 'Turma não encontrada.');
    }

    public function edit(string $id)
    {
        $turma = $this->repository->findById($id);
        $cursos = $this->cursoRepository->selectAll();
        return ($turma)
            ? view('turma.edit', compact('turma', 'cursos'))
            : view('turma.index')->with('error', 'Turma não encontrada.');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $turma = $this->repository->findById($id);
        $turma->update($request->all());

        return redirect()->route('turma.index')->with('sucesso', 'Turma editada com sucesso.');
    }

    public function destroy(string $id): RedirectResponse
    {
        return ($this->repository->delete($id))
            ? redirect()->route('turma.index')->with('sucess', 'Turma deletada com sucesso.')
            : redirect()->route('turma.index')->with('error', 'Falha ao deletar turma.');
    }

    public function getTurmasPorCurso(Request $request, string $cursoId)
    {
        $curso = $this->cursoRepository->findById(intval($cursoId));
        if (!$curso) {
            return response()->json(['error' => 'Curso não encontrado'], 404);
        }

        $turmas = $curso->turmas->map(function ($turma) {
            return ['id' => $turma->id, 'nome' => $turma->ano];
        });

        return response()->json($turmas);
    }
}
