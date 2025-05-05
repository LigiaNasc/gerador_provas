<?php
// carregar o composer
require './vendor/autoload.php';

// refernciar o namespace Dompdf
use Dompdf\Dompdf;

// instanciar e usar a classe dompdf
$dompdf = new Dompdf(['enable_remote' => true]);

$dados = "<h1>Gerando um .PDF com PHP</h1>";
$dados .= "<img src='http://localhost/gerador-prova/img/snoopytt.jpg'>";

// instaciar o método loadHtml e enviar o conteúdo do PDF
$dompdf->loadHtml($dados);

// configurar o tamanho e a orientação do papel
// landscape - imprimir no formato paisagem
// portrait - imprimir no formato retrato
$dompdf->setPaper('A4', 'portrait');

// renderizar o HTML como PDF
$dompdf->render();

// gerar PDF
$dompdf->stream();
?>