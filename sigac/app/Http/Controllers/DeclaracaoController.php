<?php

namespace App\Http\Controllers;

use App\DeclaracaoRepository;
use App\Models\Declaracao;
use App\Repositories\AlunoRepository;
use App\Repositories\ComprovanteRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeclaracaoController extends Controller
{
    private DeclaracaoRepository $repository;
    private AlunoRepository $alunoRepository;
    private ComprovanteRepository $comprovantesRepository;

    private array $regrasValidacao = [
        'hash'              => 'required|min:4|max:255',
        'data'              => 'required|date',
        'aluno_id'          => 'required|integer',
        'comprovante_id'    => 'required|integer'
    ];

    private array $mensagemErro = [
        'hash.required' => 'O campo hash é obrigatório.',
        'data.required' => 'O campo data é obrigatório.',
        'aluno_id.required' => 'O campo aluno_id é obrigatório.',
        'comprovante_id.required' => 'O campo comprovante_id é obrigatório',
    ];

    public function __construct()
    {
        $this->repository = new DeclaracaoRepository();
        $this->alunoRepository = new AlunoRepository();
        $this->comprovantesRepository = new ComprovanteRepository();
    }


    public function index(): View
    {
        return view('declaracao.index');
    }

    public function create(): View
    {
        $alunos = $this->alunoRepository->selectAll();
        $comprovantes = $this->comprovantesRepository->selectAll();
        return view('declaracao.create', compact('alunos', 'comprovantes'));
    }

    public function store(Request $request): View
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $declaracao = new Declaracao();
        $declaracao->setHash($request->get('hash'));
        $declaracao->setData($request->get('data'));
        $declaracao->setAlunoId($request->get('aluno_id'));
        $declaracao->setComprovanteId($request->get('comprovante_id'));
        $declaracao->save();

        return view('declaracao.create', compact('declaracao'));
    }

    public function show(string $id): View
    {
        $declaracao = $this->repository->findById($id);
        return ($declaracao)
            ? view('declaracao.show', compact('declaracao'))
            : view('declaracao.show')->with('error', 'Declaracao não encontrada.');
    }

    public function edit(string $id): View
    {
        $declaracao = $this->repository->findById($id);

        if($declaracao) {
            $aluno = $declaracao->aluno;
            $comprovante = $declaracao->comprovante;
            return view('declaracao.edit', compact('declaracao', 'aluno', 'comprovante'));
        }
        return view('declaracao.index')->with('error', 'Erro ao encontrar o declaracao.');
    }

    public function update(Request $request, string $id): View
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $declaracao = $this->repository->findById($id);

        if($declaracao) {
            $declaracao->update($request->all());
            return view('declaracao.index')->with('sucess', 'Declaracao atualizada com sucesso.');
        }
        return view('declaracao.index')->with('error', 'Erro ao encontrar o declaracao.');
    }

    public function destroy(string $id): View
    {
        return ($this->repository->delete($id))
            ? view('declaracao.index')->with('sucess', 'Declaracao removida com sucesso.')
            : view('declaracao.index')->with('error', 'Erro ao remover o declaracao.');
    }
}
