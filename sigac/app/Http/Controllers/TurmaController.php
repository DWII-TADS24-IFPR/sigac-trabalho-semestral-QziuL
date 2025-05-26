<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Repositories\CursoRepository;
use App\Repositories\TurmaRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TurmaController extends Controller
{
    private TurmaRepository $repository;
    private CursoRepository $cursoRepository;

    private array $regrasValidacao = [
        'turma'      => 'required|min:4|max:255',
        'curso_id'     => 'required|integer',
    ];

    private array $mensagemErro = [
        'turma.required' => 'O campo turma é obrigatório.',
        'curso_id.required' => 'O campo curso_id é obrigatório.',
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

    public function store(Request $request): View
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $turma = new Turma();
        $turma->setAno($request->get('ano'));
        $turma->setCursoId($request->get('curso_id'));
        $turma->save();

        return view('turma.index', compact('turma'))->with('sucess', 'Turma criada com sucesso.');
    }

    public function show(string $id): View
    {
        $turma = $this->repository->findById($id);
        return ($turma)
            ? view('turma.show', compact('turma'))
            : view('turma.index')->with('error', 'Turma não encontrada.');
    }

    public function edit(string $id)
    {
        $turma = $this->repository->findById($id);
        return ($turma)
            ? view('turma.edit', compact('turma'))
            : view('turma.index')->with('error', 'Turma não encontrada.');
    }

    public function update(Request $request, string $id): View
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $turma = $this->repository->findById($id);
        $turma->update($request->all());

        return view('turma.index')->with('sucesso', 'Turma editada com sucesso.');
    }

    public function destroy(string $id): View
    {
        return ($this->repository->delete($id))
            ? view('turma.index')->with('sucess', 'Turma deletada com sucesso.')
            : view('turma.index')->with('error', 'Falha ao deletar turma.');
    }
}
