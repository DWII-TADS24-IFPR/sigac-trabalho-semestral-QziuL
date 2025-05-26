<?php

namespace App\Http\Controllers;

use App\Models\Eixo;
use App\Repositories\EixoRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EixoController extends Controller
{
    private EixoRepository $repository;

    private array $regrasValidacao = [
        'nome' => 'required|min:3|max:100',
    ];

    private array $mensagemErro = [
        'nome.required' => 'O campo nome é obrigatório.',
        'nome.min' => 'O campo nome deve ter mais de 3 caracteres.',
        'nome.max' => 'O campo nome deve ter menos de 100 caracteres.',
    ];

    public function __construct() { $this->repository = new EixoRepository(); }

    public function index(): View | RedirectResponse
    {
        // Se não tiver dados registrados, exibir na View dados nulos
        $eixos = $this->repository->selectAll();
        return view('eixo.index', compact('eixos'));

//        return ($eixos)
//            ? view('eixo.index', compact('eixos'))
//            : redirect()->route("home")->with("error", "Nenhum Eixo registrado.");
    }

    public function create(): View
    {
        return view('eixo.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $eixo = new Eixo();
        $eixo->setNome(mb_strtoupper($request->get('nome'), 'UTF-8'));
        $this->repository->save($eixo);

        return redirect()->route('eixo.index')->with('success', 'Eixo cadastrado com sucesso!');
    }

    public function show(int $id): View | RedirectResponse
    {
        $eixo = $this->repository->findById($id);
        return ($eixo)
            ? view('eixo.show', compact('eixo'))
            : redirect()->route('eixo.index')->with('error', 'Eixo não encontrado.');
    }

    public function edit(int $id): View | RedirectResponse
    {
        $eixo = $this->repository->findById($id);
        return ($eixo)
            ? redirect()->view('eixo.edit', compact('eixo'))
            : redirect()->route('eixo.index')->with('error', 'Eixo não encontrado.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $eixo = $this->repository->findById($id);

        if(isset($eixo)) {
            $eixo->setNome(mb_strtoupper($request->get('nome'), 'UTF-8'));
            $this->repository->save($eixo);
            return redirect()->route('eixo.index')->with('success', 'Eixo atualizado com sucesso!');
        }

        return redirect()->route('eixo.index')->with('error', 'Eixo não encontrado.');
    }

    public function destroy(int $id): RedirectResponse
    {
        return ($this->repository->delete($id))
            ? redirect()->route('eixo.index')->with('sucess', 'Eixo deletado com sucesso!')
            : redirect()->route('eixo.index')->with('error', 'Falha ao deletar.');
    }
}
