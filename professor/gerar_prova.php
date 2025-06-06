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
    body { font-family: Arial, sans-serif; font-size:120px; }
    .header { text-align: center; margin-bottom: 5px; }
    header img { width: 100px; }
    h1 { font-size: 16px; margin-bottom: 5px; }
    .info { margin-bottom: 5px; }
    .info p { margin: 2px 0; font-size: 13px; }
    .cabecalho { margin: 5px 0; }
    .pzinho { font-size: 12px; }
    ol { margin-top: 5px; padding-left: 20px; }
    .questao { margin-bottom: 5px; }
    ul { margin-top: 2px; margin-bottom: 5px; padding-left: 20px; }
    li { margin-bottom: 2px; }
</style>
    <header class='header'>
         <img src='http://localhost/gerador-prova/img/logo_escola.png' alt='Logo da Escola'><br>
         <h1>{$prova['nome_prova']}</h1>
     </header>

<div class='info'>
    <p><strong>Aluno:</strong> ___________________________________________</p>
    <p><strong>Data:</strong> ____/____/______</p>
</div>

<hr class='cabecalho'>

    <p class=pzinho >{$prova['cabecalho']}</p>

<hr>
<ol>";

foreach ($questoes as $q) {
    $html .= "<li class='questao'>
               
                <p><strong>{$q['enunciado']}</strong></p>";

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

$html .= "</ol>";

// Configurar o Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); 

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Rodapé
$canvas = $dompdf->getCanvas();
$font = $dompdf->getFontMetrics()->getFont('Helvetica', 'normal');
$canvas->page_text(270, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 8, [0, 0, 0]);

ob_end_clean();
$dompdf->stream("prova_{$id_prova}.pdf", ["Attachment" => false]);


?>
