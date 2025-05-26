<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Repositories\AlunoRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\DocumentoRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentoController extends Controller
{
    private DocumentoRepository $repository;
    private CategoriaRepository $categoriaRepository;
    private AlunoRepository $alunoRepository;

    private array $regrasValidacao = [
        'url'           => 'required|string',
        'descricao'     => 'required|string',
        'horas_in'      => 'required|float',
        'horas_out'     => 'required|float',
        'status'        => 'required|string',
        'comentario'    => 'required|string',
        'categoria_id'  => 'required|integer',
        'aluno_id'      => 'required|integer',
    ];

    private array $mensagemErro = [
        'url.required'          => 'O campo hash é obrigatório.',
        'descricao.required'    => 'O campo data é obrigatório.',
        'horas_in.required'     => 'O campo aluno_id é obrigatório.',
        'horas_out.required'    => 'O campo comprovante_id é obrigatório.',
        'status.required'       => 'O campo status é obrigatório.',
        'comentario.required'   => 'O campo comentario é obrigatório.',
        'categoria_id.required' => 'O campo categoria_id é obrigatório.',
        'aluno_id.required'     => 'O campo aluno_id é obrigatório.',
    ];

    public function __construct()
    {
        $this->repository = new DocumentoRepository();
        $this->categoriaRepository = new CategoriaRepository();
        $this->alunoRepository = new AlunoRepository();
    }


    public function index(): View
    {
        $documentos = $this->repository->selectAll();
        return view('documento.index');
    }

   public function create(): View
    {
        $documentos = $this->repository->selectAll();
        $alunos     = $this->alunoRepository->selectAll();
        $categorias = $this->categoriaRepository->selectAll();

        return view('documento.create', compact('documentos', 'alunos', 'categorias'));
    }

    public function store(Request $request): View
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $documento = new Documento();
//        $documento->fill($request->all());
        $documento->setUrl($request->get('url'));
        $documento->setDescricao($request->get('descricao'));
        $documento->setHorasIn($request->get('horas_in'));
        $documento->setHorasOut($request->get('horas_out'));
        $documento->setStatus($request->get('status'));
        $documento->setComentario($request->get('comentario'));
        $documento->setCategoriaId($request->get('categoria_id'));
        $documento->setUserId($request->get('aluno_id'));
        $documento->save();

        return view('documento.index')->with('sucess', 'Documento criado com sucesso.');
    }

    public function show(string $id): View
    {
        $documento = $this->repository->findById($id);

        return ($documento)
            ? view('documento.show', compact('documento'))
            : view('documento.index')->with('error', 'Documento não encontrado.');
    }

    public function edit(string $id): View
    {
        $documento = $this->repository->findById($id);

        return ($documento)
            ? view('documento.edit', compact('documento'))
            : view('documento.index')->with('error', 'Documento não encontrado.');
    }

    public function update(Request $request, string $id): View
    {
        $request->validate($this->regrasValidacao, $this->mensagemErro);

        $documento = $this->repository->findById($id);
        if (!$documento)
            return view('documento.index')->with('error', 'Documento não encontrado.');
        $documento->update($request->all());

        return view('documento.index')->with('sucess', 'Documento atualizado com sucesso.');
    }

    public function destroy(string $id): View
    {
        return ($this->repository->delete($id))
            ? view('documento.index')->with('sucess', 'Documento removido com sucesso.')
            : view('documento.index')->with('error', 'Falha ao deletar o documento.');
    }
}
