<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Repositories\CategoriaRepository;
use App\Repositories\CursoRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    private CategoriaRepository $repository;
    private CursoRepository $cursoRepository;

    private array $regrasValidacao = [
        'nome' => 'required|min:3|max:255',
        'curso_id' => 'required|integer|exists:cursos,id',
        'maximo_horas' => 'required|integer|min:1|max:999',
    ];

    // TODO - Error Messages
    private array $mensagemErro = [
        'nome.required' => 'o campo nome é obrigatorio',
        'curso_id.required' => 'o campo curso é obrigatorio',
        'maximo_horas.required' => 'o campo maximo horas é obrigatorio',
    ];

    public function __construct()
    {
        $this->repository = new CategoriaRepository();
        $this->cursoRepository = new CursoRepository();
    }


    public function index(): View
    {
        $categorias = $this->repository->selectAll();
        return view('categoria.index', compact('categorias'));
    }

    public function create(): View
    {
        $cursos = $this->cursoRepository->selectAll();
        return view('categoria.create', compact('cursos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $categoria = new Categoria();
        $categoria->setNome(mb_strtoupper($request->get('nome'), 'UTF-8'));
        $categoria->setMaximoHoras($request->get('maximo_horas'));
        $categoria->setCursoId($request->get('curso_id'));
        $categoria->save();

        return redirect()->route('categoria.index')->with('sucess', 'Categoria cadastrada com sucesso!');

    }

    public function show(int $id): View | RedirectResponse
    {
        $categoria = $this->find($id);

        return (isset($categoria))
            ? view('categoria.show', compact('categoria'))
            : redirect()->back()->with('error', 'Categoria não encontrada.');
    }

    public function edit(int $id): View
    {
        $categoria = $this->find($id);
        $cursos = $this->cursoRepository->selectAll();
        return view('categoria.edit', compact('categoria', 'cursos'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $categoria = $this->find($id);
        if(isset($categoria)) {
            $categoria->setNome(mb_strtoupper($request->get('nome'), 'UTF-8'));
            $categoria->setMaximoHoras($request->get('maximo_horas'));
            $categoria->setCursoId(intval($request->get('curso_id')));
            $categoria->save();

            return redirect()->route('categoria.index')->with('sucess', 'Categoria atualizada com sucesso!');
        }

        return redirect()->route('categoria.index')->with('error', 'Erro ao atualizar categoria.');
    }

    public function destroy(int $id): RedirectResponse
    {
        return ($this->repository->delete($id))
            ? redirect()->route('categoria.index')->with('sucess', 'Categoria deletada com sucesso!')
            : redirect()->route('categoria.index')->with('error', 'Falha ao deletar categoria.');
    }

    private function find(int $id) {
        return $this->repository->findById($id);
    }
}
