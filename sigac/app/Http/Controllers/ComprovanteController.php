<?php

namespace App\Http\Controllers;

use App\Models\Comprovante;
use App\Repositories\AlunoRepository;
use App\Repositories\ComprovanteRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComprovanteController extends Controller
{
    private ComprovanteRepository $repository;
    private AlunoRepository $alunoRepository;

    private array $regrasValidacao = [
        'horas' => 'required|integer|min:1|max:999',
        'atividade' => 'required|string|min:3|max:255',
        'categoria_id' => 'required|integer',
        'aluno_id' => 'required|integer',
        'user_id' => 'required|integer',
    ];

    // TODO - Error messages
    private array $mensagemErro = [
        'horas.required' => 'O campo horas é obrigatorio.',
        'atividade.required' => 'O campo atividade é obrigatorio.',
        'categoria_id' => 'O campo categoria_id é obrigatorio.',
        'aluno_id' => 'O campo aluno é obrigatorio.',
        'user_id.required' => 'O campo user_id é obrigatorio.',
    ];

    public function __construct()
    {
        $this->repository = new ComprovanteRepository();
        $this->alunoRepository = new AlunoRepository();
    }


    public function index(): View
    {
        $comprovantes = $this->repository->selectAll();
        return view('comprovante.index', compact('comprovantes'));
    }

    public function create(): View
    {
        $alunos = $this->alunoRepository->selectAll();
        return view('comprovante.create', compact('alunos'));
    }

    public function store(Request $request): View
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $comprovante = new Comprovante();
        $comprovante->setHoras($request->input('horas'));
        $comprovante->setAtividade(mb_strtoupper($request->input('atividade')));
        $comprovante->setCategoriaId($request->input('categoria_id'));
        $comprovante->setAlunoId($request->input('aluno_id'));
        $comprovante->setUserId($request->input('user_id'));
        $comprovante->save();

        return view('comprovante.create')->with('sucess', 'Comprovante cadastrado com sucesso.');
    }

    public function show(int $id): View
    {
        $comprovante = $this->find($id);

        return (isset($comprovante))
            ? view('comprovante.show', compact('comprovante'))
            : view('comprovante.index')->with('error','Comprovante não encontrado.');
    }

    public function edit(int $id): View
    {
        $comprovante = $this->find($id);

        return (isset($comprovante))
            ? view('comprovante.edit', compact('comprovante'))
            : view('comprovante.index')->with('error', 'Comprovante não encontrado.');
    }

    public function update(Request $request, int $id): View
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $comprovante = $this->find($id);

        if (isset($comprovante))
        {
            $comprovante->setHoras($request->input('horas'));
            $comprovante->setAtividade(mb_strtoupper($request->input('atividade')));
            $comprovante->setCategoriaId($request->input('categoria_id'));
            $comprovante->setAlunoId($request->input('aluno_id'));
            $comprovante->setUserId($request->input('user_id'));
            $comprovante->save();

            return view('comprovante.index')->with('sucess', 'Comprovante atualizado com sucesso.');
        }

        return view('comprovante.index')->with('error', 'Falha ao atualizar o comprovante.');
    }

    public function destroy(int $id): View
    {
        return ($this->repository->delete($id))
            ? view('comprovante.index')->with('sucess', 'Sucesso ao deletar comprovante.')
            : view('comprovante.index')->with('error', 'Falha ao deletar comprovante.');
    }

    private function find(int $id): object | null
    {
        return $this->repository->findById($id);
    }
}
