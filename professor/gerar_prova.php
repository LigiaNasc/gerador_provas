<?php
require '../vendor/autoload.php';
require_once('../conex.php');
require_once('../protect.php');
include('verificar_professor.php');
use Dompdf\Dompdf;
use Dompdf\Options;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

verificarProfessor();
$conn = getConexao();

$id_prova = $_GET['id'] ?? null;
if (!$id_prova) {
    die("ID da prova não informado.");
}

// Buscar dados da prova
$stmt = $conn->prepare("
    SELECT p.nome AS nome_prova, p.cabecalho
    FROM provas p
    WHERE p.id = :id_prova AND p.professor_id = :professor_id
");
$stmt->execute([
    'id_prova' => $id_prova,
    'professor_id' => $_SESSION['id']
]);
$prova = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$prova) {
    die("Prova não encontrada ou você não tem permissão.");
}

// Buscar questões da prova
$stmt = $conn->prepare("
    SELECT q.id, q.enunciado, d.nome AS disciplina, a.nome AS assunto
    FROM prova_questoes qp
    JOIN questoes q ON qp.questao_id = q.id
    JOIN disciplinas d ON q.disciplina_id = d.id
    JOIN assuntos a ON q.assunto_id = a.id
    WHERE qp.prova_id = :id_prova
");
$stmt->execute(['id_prova' => $id_prova]);
$questoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gerar o HTML da prova
$html = "
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; margin: 50px 40px 80px 40px; }
    header { text-align: center; margin-bottom: 20px; }
    header img { width: 100px; }
    h1 { font-size: 20px; margin-bottom: 5px; }
    .info { margin-bottom: 20px; }
    .info p { margin: 5px 0; }
    hr { margin: 20px 0; }
    ol { margin-top: 20px; }
    .questao { margin-bottom: 30px; }
    footer { position: fixed; bottom: -30px; left: 0; right: 0; height: 50px; text-align: center; font-size: 10px; }
</style>

<header>
    <img src='http://localhost/gerador-prova/img/logo_escola.png' alt='Logo da Escola'><br>
    <h1>{$prova['nome_prova']}</h1>
</header>

<div class='info'>
    <p><strong>Aluno:</strong> ___________________________________________</p>
    <p><strong>Data:</strong> ____/____/______</p>
</div>

<hr>

<p>{$prova['cabecalho']}</p>

<hr>

<h2>Questões:</h2>
<ol>";

foreach ($questoes as $q) {
    $html .= "<li class='questao'>
                <p><strong>Disciplina:</strong> {$q['disciplina']} | 
                   <strong>Assunto:</strong> {$q['assunto']}</p>
                <p>{$q['enunciado']}</p>";

    // Buscar alternativas dessa questão
    $stmt_alt = $conn->prepare("
        SELECT texto
        FROM alternativas
        WHERE questao_id = :questao_id
    ");
    $stmt_alt->execute(['questao_id' => $q['id']]);
    $alternativas = $stmt_alt->fetchAll(PDO::FETCH_ASSOC);

    // Listar as alternativas
    if ($alternativas) {
        $html .= "<ul type='A'>"; // Letra A, B, C...
        foreach ($alternativas as $alt) {
            $html .= "<li>{$alt['texto']}</li>";
        }
        $html .= "</ul>";
    }

    $html .= "</li>";
}

$html .= "</ol>

<footer>
    Página <span class='pageNumber'></span> de <span class='totalPages'></span>
</footer>";

// Configurar o Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); // importante para carregar imagem externa

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Adicionar número de páginas no rodapé (CORRETO AGORA)
$canvas = $dompdf->getCanvas();
$font = $dompdf->getFontMetrics()->getFont('Arial', 'normal');
$canvas->page_text(520, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0, 0, 0));

// Gerar o PDF no navegador
$dompdf->stream("prova_{$id_prova}.pdf", ["Attachment" => false]);
?>
