<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\User;
use App\Repositories\AlunoRepository;
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
    private string $path = 'documentos/alunos';
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
            // Registra a Solicitação
            $documento = new Documento();
            $documento->setDescricao(mb_strtoupper($request->get('descricao'), 'UTF-8'));
            $documento->setHorasIn($request->get('horas_in'));
            $documento->setStatus(false);
            $documento->categoria()->associate($categoria);
            $documento->user()->associate($user);
            $id = $this->repository->saveAndReturnId($documento);
            // Upload documento salvando em 'storage/app/private/public/documentos/alunos'
            // altera nome do arquivo com ID do aluno e horario
            $extensao_arq = $request->file('documento')->getClientOriginalExtension();
            $nome_arq = $id.'_'.time().'.'.$extensao_arq;
            $path = $request->file('documento')->storeAs('public/documentos/alunos', $nome_arq);
            $documento->setUrl($path);
            $this->repository->save($documento);
            return redirect()->route('documento.index');
        }

        return redirect()->route('documento.index');
    }

    public function show(string $id): View | RedirectResponse
    {
        $documento = $this->repository->findById($id);

        return ($documento)
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
