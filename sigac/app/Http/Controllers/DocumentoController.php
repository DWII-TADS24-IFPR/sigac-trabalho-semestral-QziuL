<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\User;
use App\Repositories\CategoriaRepository;
use App\Repositories\DocumentoRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DocumentoController extends Controller
{
    private DocumentoRepository $repository;
    private CategoriaRepository $categoriaRepository;

    private array $regrasValidacao = [
        'descricao' => 'required|min:5|max:200',
        'horas_in' => 'required',
        'categoria_id' => 'required',
        'documento' => 'required|file|mimes:pdf|max:2048',
    ];

    private array $mensagemErro = [
        'descricao.required'    => 'O campo descrição é obrigatório.',
        'horas_in.required'     => 'O campo horas é obrigatório.',
        'categoria_id.required' => 'O campo categoria é obrigatório.',
        'documento.required'     => 'O campo documento é obrigatório.',
    ];

    public function __construct()
    {
        $this->repository = new DocumentoRepository();
        $this->categoriaRepository = new CategoriaRepository();
    }


    public function index(): View
    {
        $documentos = $this->repository->selectAll();
        return view('documento.index', compact('documentos'));
    }

   public function create(): View
    {
        $categorias = $this->categoriaRepository->selectAll();
        return view('documento.create', compact( 'categorias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $categoria = $this->categoriaRepository->findById($request->get('categoria_id'));
        $user = User::find(Auth::id());
        if($request->file('documento') && isset($categoria) && isset($user)) {
            $documento = new Documento();
            $documento->setDescricao(mb_strtoupper($request->get('descricao'), 'UTF-8'));
            $documento->setHorasIn($request->get('horas_in'));
            $documento->setStatus(false);
            $documento->categoria()->associate($categoria);
            $documento->user()->associate($user);
            // salva o arquivo em 'storage/app/public/documentos'
            // alterando o nome com dados do ID do aluno e hora atual
            $extensao_arq = $request->file('documento')->getClientOriginalExtension();
            $nome_arq = $user->id.'_'.time().'.'.$extensao_arq;
            $pathSave = $request->file('documento')->storeAs('documentos', $nome_arq, 'public');
            $documento->setUrl($pathSave);
            $this->repository->save($documento);
            return redirect()->route('documento.index')->with('success', 'Documento cadastrado com sucesso.');
        }

        return redirect()->route('documento.index')->with('error', 'Ocorreu um erro ao cadastrar o documento.');
    }

    public function show(string $id): View | RedirectResponse
    {
        $documento = $this->repository->findById(intval($id));
        return (isset($documento))
            ? view('documento.show', compact('documento'))
            : redirect()->route('documento.index')->with('error', 'Documento não encontrado.');
    }

    public function edit(string $id): View | RedirectResponse
    {
        $documento = $this->repository->findById(intval($id));
        $categorias = $this->categoriaRepository->selectAll();
        return (isset($documento))
            ? view('documento.edit', compact('documento', 'categorias'))
            : redirect()->route('documento.index')->with('error', 'Documento não encontrado.');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $documento = $this->repository->findById($id);
        if (!$documento)
            return redirect()->route('documento.index')->with('error', 'Documento não encontrado.');
        $documento->update($request->all());

        return redirect()->route('documento.index')->with('sucess', 'Documento atualizado com sucesso.');
    }

    public function destroy(string $id): RedirectResponse
    {
        return ($this->repository->delete($id))
            ? redirect()->route('documento.index')->with('sucess', 'Documento removido com sucesso.')
            : redirect()->route('documento.index')->with('error', 'Falha ao deletar o documento.');
    }
}
