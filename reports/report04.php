<?php

ini_set('display_errors', 1);

require_once  "../vendor/autoload.php";
require_once "../dao/reportDAO.php";

session_start();
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['password']) == true))
{
    unset($_SESSION['login']);
    unset($_SESSION['password']);
    header('location: ../login.php');
}else{

    $dao = new reportDAO();

    $listObjs = $dao->report04();
    $dia = $dao ->dateNow();
    $hr = $dao ->hourNow();

    $html = "<table border='2' cellspacing='3' cellpadding='5' >";
    $html .= "<tr>
                    <th>LIVRO</th>
                    <th>ISBN</th>
                    <th>EDITORA</th>
                </tr>";
    foreach ($listObjs as $var):
        $html.= "<tr>
                        <td>$var->Titulo</td>
                        <td>$var->isbn</td>
                        <td>$var->Nome</td>
                  </tr>";
    endforeach;
    $html .= "</table>";

    $mpdf=new \Mpdf\Mpdf();
    $mpdf->SetCreator('PDF_CREATOR');
    $mpdf->SetAuthor('Leonardo');
    $mpdf->SetTitle('Relatório PDF de todos os livros reservados');
    $mpdf->SetSubject('Store Library');
    $mpdf->SetKeywords('TCPDF, StoreLib');
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->nbpgPrefix = ' de ';
    $mpdf->setFooter("Relatório gerado no dia {$dia} às {$hr} - Página {PAGENO}{nbpg}");
    $mpdf->WriteHTML($html);
    $mpdf->Output('StoreLibrary.pdf','I');

}