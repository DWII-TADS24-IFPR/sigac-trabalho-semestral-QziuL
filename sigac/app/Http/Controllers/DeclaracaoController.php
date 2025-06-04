<?php

namespace App\Http\Controllers;

use App\Repositories\AlunoRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\ComprovanteRepository;
use App\Repositories\DeclaracaoRepository;
use App\Repositories\DocumentoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Dompdf\Dompdf;

class DeclaracaoController extends Controller
{
    private DeclaracaoRepository $repository;
    private AlunoRepository $alunoRepository;
    private ComprovanteRepository $comprovantesRepository;
    private DocumentoRepository $documentoRepository;
    private CategoriaRepository $categoriaRepository;
    private $alunoHoras = 0;

//    private array $regrasValidacao = [
//        'hash'              => 'required|min:4|max:255',
//        'data'              => 'required|date',
//        'aluno_id'          => 'required|integer',
//        'comprovante_id'    => 'required|integer'
//    ];
//
//    private array $mensagemErro = [
//        'hash.required' => 'O campo hash é obrigatório.',
//        'data.required' => 'O campo data é obrigatório.',
//        'aluno_id.required' => 'O campo aluno_id é obrigatório.',
//        'comprovante_id.required' => 'O campo comprovante_id é obrigatório',
//    ];

    public function __construct()
    {
        $this->repository = new DeclaracaoRepository();
        $this->alunoRepository = new AlunoRepository();
        $this->comprovantesRepository = new ComprovanteRepository();
        $this->documentoRepository = new DocumentoRepository();
        $this->categoriaRepository = new CategoriaRepository();
    }


    public function index(): View
    {
        $user = auth()->user();
        $aluno = $this->alunoRepository->findByColumn('email', $user->email)->first();
        list($alunoHoras, $cursoHoras, $cursoConcluido) = $this->totalDeHorasAluno($aluno);

        $this->alunoHoras = $alunoHoras;
        return view('declaracao.index',
            compact('aluno','alunoHoras','cursoHoras','cursoConcluido'));
    }

    public function create()
    {
//        $categorias = $this->categoriaRepository->selectAll();
//        $alunos = $this->alunoRepository->selectAll();
//        $alunoHoras = $this->alunoHoras;
//        return view('declaracao.create', compact('categorias', 'alunos', 'alunoHoras'));
    }

    public function store(Request $request)
    {
        $aluno = $this->alunoRepository->findByColumn('email', $request->get('aluno-email'))->first();
        $cursoHoras = $aluno->curso->total_horas;

        $dateNow = date("d/m/Y", time());

        $dompdf = new Dompdf();
        $hashAssinatura = Hash::make($aluno->id + time());

        $dompdf->loadHtml(view('declaracao.declaracao-pdf',
            compact('aluno', 'cursoHoras', 'dateNow', 'hashAssinatura')));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream();
    }

    public function show(string $id)
    {
//        $declaracao = $this->repository->findById($id);
//        return ($declaracao)
//            ? view('declaracao.show', compact('declaracao'))
//            : view('declaracao.show')->with('error', 'Declaracao não encontrada.');
    }

    public function edit(string $id)
    {
//        $declaracao = $this->repository->findById($id);
//
//        if($declaracao) {
//            $aluno = $declaracao->aluno;
//            $comprovante = $declaracao->comprovante;
//            return view('declaracao.edit', compact('declaracao', 'aluno', 'comprovante'));
//        }
//        return view('declaracao.index')->with('error', 'Erro ao encontrar o declaracao.');
    }

    public function update(Request $request, string $id)
    {
//        $request->validate($this->regrasValidacao, $this->mensagemErro);
//
//        $declaracao = $this->repository->findById($id);
//
//        if($declaracao) {
//            $declaracao->update($request->all());
//            return view('declaracao.index')->with('sucess', 'Declaracao atualizada com sucesso.');
//        }
//        return view('declaracao.index')->with('error', 'Erro ao encontrar o declaracao.');
    }

    public function destroy(string $id)
    {
//        return ($this->repository->delete($id))
//            ? view('declaracao.index')->with('sucess', 'Declaracao removida com sucesso.')
//            : view('declaracao.index')->with('error', 'Erro ao remover o declaracao.');
    }

    public function totalDeHorasAluno($aluno): array
    {
        $documentos = $this->documentoRepository->selectAll();

        $alunoHoras = 0;
        $cursoHoras = $aluno->curso->total_horas;
        $cursoConcluido = false;

        foreach ($documentos as $documento) {
            if ($documento->user_id == $aluno->user_id && $documento->status == 1) {
                $alunoHoras += $documento->horas_out;
            }
        }

        if ($alunoHoras >= $cursoHoras) {
            $cursoConcluido = true;
        }

        return array($alunoHoras, $cursoHoras, $cursoConcluido);
    }
}
