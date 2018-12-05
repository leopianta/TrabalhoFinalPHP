<?php

require_once '../vendor/davefx/phplot/phplot/phplot.php';
require_once "../db/connection.php";

#Instancia o objeto e setando o tamanho do grafico na tela
$grafico = new PHPlot(600 ,600);

//formato do grafico
$grafico->SetFileFormat("png");

#Indicamos o títul do gráfico e o título dos dados no eixo X e Y do mesmo
$grafico->SetTitle("");
$grafico->SetXTitle("mes");
$grafico->SetYTitle("total");

//select de pesquisa
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

//gráfico em barras
$grafico->SetPlotType("bars");

//Exibimos o gráfico
$grafico->DrawGraph();