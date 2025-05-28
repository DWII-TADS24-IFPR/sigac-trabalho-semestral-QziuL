<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Repositories\CursoRepository;
use App\Repositories\EixoRepository;
use App\Repositories\NivelRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CursoController extends Controller
{
    private CursoRepository $cursoRepository;
    private NivelRepository $nivelRepository;
    private EixoRepository $eixoRepository;

    private array $regrasValidacao = [
        'nome' => 'required|min:3|max:255',
        'sigla' => 'required|min:3|max:6',
        'total_horas' => 'required|numeric|min:1|max:999',
        'nivel_id' => 'required',
        'eixo_id' => 'required',
    ];

    private array $mensagemErro = [
        'nome.required' => 'O campo nome é obrigatorio',
        'sigla.required' => 'O campo sigla é obrigatorio',
        'total_horas.required' => 'O campo total horas é obrigatorio',
        'nivel_id.required' => 'O campo nivel_id é obrigatorio',
        'eixo_id.required' => 'O campo eixo id é obrigatorio',
    ];

    public function __construct()
    {
        $this->cursoRepository = new CursoRepository();
        $this->nivelRepository = new NivelRepository();
        $this->eixoRepository = new EixoRepository();
    }

    public function index(): View
    {
        $cursos = $this->cursoRepository->selectAll();
        return view('curso.index', compact('cursos'));
    }

    public function create(): View
    {
        /*
         Lá na View eu puxo esses objetos e
         ao criar um novo curso eu atribuo os IDs
        */
        $niveis = $this->nivelRepository->selectAll();
        $eixos = $this->eixoRepository->selectAll();
        return view('curso.create', compact('niveis', 'eixos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $curso = new Curso();
        $curso->setNome(mb_strtoupper($request->get('nome')));
        $curso->setSigla(mb_strtoupper($request->get('sigla')));
        $curso->setTotalHoras($request->get('total_horas'));
        $curso->setNivelId(intval($request->get('nivel_id')));
        $curso->setEixoId(intval($request->get('eixo_id')));
        $curso->save();

        return redirect()->route('curso.index')->with('sucess', 'Curso cadastrado com sucesso!');
    }

    public function show(string $id): View | RedirectResponse
    {
        $curso = $this->find($id);
        return (isset($curso))
            ? view('curso.show', compact('curso'))
            : redirect()->back()->with('error', 'Curso não encontrado.');
    }

    public function edit(string $id): View | RedirectResponse
    {
        $curso = $this->find($id);
        $niveis = $this->nivelRepository->selectAll();
        $eixos = $this->eixoRepository->selectAll();
        return (isset($curso))
            ? view('curso.edit', compact('curso', 'niveis', 'eixos'))
            : redirect()->route('curso.index')->with('error', 'Curso não encontrado');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $curso = $this->find($id);
        if (isset($curso)) {
            $curso->update($request->all());
            return redirect()->route('curso.index')->with('sucess', 'Curso atualizado com sucesso!');
        }
        return redirect()->route('curso.index')->with('error', 'Curso não encontrado');
    }

    public function destroy(string $id): RedirectResponse
    {
        return ($this->find($id)->softDeletes())
            ? redirect()->route('curso.index')->with('sucess', 'Curso deletado com sucesso!')
            : redirect()->route('curso.index')->with('error', 'Falha ao deletar.');
    }

    private function find(int $id): object | null
    {
        return $this->cursoRepository->findById($id);
    }
}
