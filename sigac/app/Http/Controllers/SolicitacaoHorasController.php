<?php

namespace App\Http\Controllers;

use App\Repositories\AlunoRepository;
use App\Repositories\DocumentoRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SolicitacaoHorasController extends Controller
{
    private AlunoRepository $alunoRepository;
    private DocumentoRepository $documentoRepository;

    /**
     * @param AlunoRepository $alunoRepository
     * @param DocumentoRepository $documentoRepository
     */
    public function __construct()
    {
        $this->alunoRepository = new AlunoRepository;
        $this->documentoRepository = new DocumentoRepository;
    }

    public function index()
    {
        $documentos = $this->documentoRepository->selectAll();
        return view('solicitacao.index', compact('documentos'));
    }

    public function refused(string $id) {
        return view('solicitacao.refused')->with('id', intval($id));
    }

    public function refusedStore(Request $request, string $id): RedirectResponse
    {
        $documento = $this->documentoRepository->findById(intval($id));
        $documento->setStatus(false);
        $documento->setComentario($request->get('comentario'));
        $documento->save();
        return redirect()->route('solicitacao.index')->with('success', 'Solicitação recusada com sucesso!');
    }

    public function approved(string $id): RedirectResponse
    {
        $documento = $this->documentoRepository->findById(intval($id));
        $documento->setStatus(true);
        $documento->save();
        return redirect()->route('solicitacao.index')->with('success', 'Solicitação aprovada!');
    }
}
