<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Declaração de Cumprimento de Horas</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Roboto:wght@400;500&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.2;
            color: #4A4A4A;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container-declaracao {
            background-color: #ffffff;
            padding: 20mm 25mm;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            margin: 0 auto;
        }

        header {
            text-align: center;
            border-bottom: 3px solid #4A90E2;
        }

        header h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 22px;
            color: #4A90E2;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 17px;
            color: #333;
            font-weight: 600;
            border-bottom: 1px solid #e0e0e0;
        }

        .dados-aluno p,
        .horas-cumpridas p {
            font-size: 12pt;
            color: #555;
        }

        .dados-aluno p strong,
        .horas-cumpridas p strong {
            font-weight: 500;
            color: #222;
        }

        .horas-cumpridas {
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .assinatura {
            border-top: 1px dashed #cccccc;
            text-align: center;
        }

        .assinatura p {
            font-size: 11pt;
            color: #666;
        }

        .hash-assinatura {
            font-family: 'Courier New', Courier, monospace;
            background-color: #eef1f5;
            border-radius: 4px;
            display: inline-block;
            word-break: break-all;
            font-size: 10pt;
            color: #4A4A4A;
        }

        .data-emissao {
            font-style: normal;
            color: #777;
            font-size: 10pt;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            font-size: 9.5pt;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container-declaracao">
    <header>
        <h1>DECLARAÇÃO DE CUMPRIMENTO DE HORAS AFINS</h1>
    </header>

    <section class="dados-aluno">
        <h2>Dados do Aluno</h2>
        <p><strong>Nome:</strong> <span id="nome-aluno">{{ $aluno->nome }}</span></p>
        <p><strong>Curso:</strong> <span id="curso-aluno">{{ $aluno->curso->nome }}</span></p>
        <p><strong>Turma:</strong> <span id="turma-aluno">{{ $aluno->turma->ano }}</span></p>
    </section>

    <section class="horas-cumpridas">
        <h2>Horas Cumpridas</h2>
        <p>Declaramos para os devidos fins que o(a) aluno(a) acima qualificado(a) cumpriu um total de
            <strong><span id="total-horas">{{ $cursoHoras }}</span> horas</strong>
            referentes às atividades afins, exigidas para a conclusão do seu curso.
        </p>
    </section>

    <section class="assinatura">
        <h2>Assinatura Digital</h2>
        <p class="hash-assinatura">
            <span id="hash-assinatura">{{ $hashAssinatura }}</span>
        </p>
        <p class="data-emissao">
            Emitido em: <span id="data-emissao">{{ $dateNow }}</span>
        </p>
    </section>

    <footer>
        <p>Instituto Federal do Paraná - Campus Paranaguá.</p>
        <p>Gerado pelo sistema SIGAC.</p>
    </footer>
</div>
</body>
</html>
