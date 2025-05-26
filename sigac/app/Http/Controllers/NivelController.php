<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use App\Repositories\NivelRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NivelController extends Controller
{
    private NivelRepository $repository;

    private array $regrasValidacao = [
        'nome' => 'required|min:3|max:100',
    ];

    private array $mensagemErro = [
        'nome.required' => 'O campo nome é obrigatorio.',
        'nome.min' => 'O campo nome deve ter mais de 3 caracteres.',
        'nome.max' => 'O campo nome deve ter menos de 100 caracteres.',
    ];

    public function __construct(){
        $this->repository = new NivelRepository();
    }

    public function index(): View
    {
        $niveis = $this->repository->selectAll();
        return view('nivel.index', compact('niveis'));
    }

    public function create(): View
    {
        return view('nivel.create');
    }

    public function store(Request $request): View
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $nivel = new Nivel();
        $nivel->setNome(mb_strtoupper($request->get('nome'), 'UTF-8'));
        $this->repository->save($nivel);

        return view('nivel.create')->with('success', 'Nivel cadastrado com sucesso.');
    }

    public function show(string $id): View | RedirectResponse
    {
        $nivel = $this->repository->findById($id);
        return (isset($nivel))
            ? view('nivel.show', compact('nivel'))
            : redirect()->back()->with('error', 'Nivel não encontrado.');
    }

    public function edit(string $id): View | RedirectResponse
    {
        $nivel = $this->repository->findById($id);
        return (isset($nivel))
            ? view('nivel.edit', compact('nivel'))
            : redirect()->back()->with('error', 'Nivel não encontrado.');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $nivel = $this->repository->findById($id);

        if(isset($nivel)) {
            $nivel->setNome(mb_strtoupper($request->nome, 'UTF-8'));
            $this->repository->save($nivel);
            return redirect()->back()->with('success', 'Nivel atualizado com sucesso.');
        }
        return redirect()->back()->with('error', 'Nivel não encontrado.');
    }

    public function destroy(string $id): RedirectResponse
    {
        return ($this->repository->delete($id))
            ? redirect()->back()->with('success', 'Nivel deletado com sucesso.')
            : redirect()->back()->with('error', 'Falha ao deletar.');
    }
}
