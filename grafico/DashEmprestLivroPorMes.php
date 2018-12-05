<?php

require_once '../vendor/davefx/phplot/phplot/phplot.php';
require_once "../db/connection.php";
require_once '../grafico/Dash_images.php';

//Instancia o objeto e setando o tamanho do grafico na tela
$grafico = new PHPlot(600 ,600);

//Indicamos o títul do gráfico e o título dos dados no eixo X e Y
$grafico->SetTitle("");
$grafico->SetXTitle("mes");
$grafico->SetYTitle("total");

$query = "SELECT 
    Count(l.idLivro) valor, Month(r.DataEmprestimo) as mes
FROM
    livro l
        JOIN
    reserva r ON l.idLivro = r.Livro_idLivro
WHERE
    r.emprestimoSN = 1
  AND month(Now()) - Month(DataReserva) <= 3
GROUP BY l.idLivro;";

$statement = $pdo->prepare($query);
$statement->execute();
$rs = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($rs as $value) {
    $resultado[] = $value;
}

$data = array();

if(isset($resultado)) {
    foreach ($resultado as $r){
        $data[] = [$r['mes'], $r['valor']];
    }
} else {
    $data[]=[null,null];
}


$grafico->SetDataValues($data);

#Neste caso, usariamos o gráfico em barras
$grafico->SetPlotType("bars");

$grafico->SetPrecisionY(1);

//Disable image output
$grafico->SetPrintImage(false);
//Draw the graph
$grafico->DrawGraph();

$pdf = new PDF_MemImage();
$pdf->AddPage();
$pdf->GDImage($grafico->img,30,20,140);
$pdf->Output();
return $grafico->EncodeImage('base64');