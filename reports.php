<?php

require_once "classes/template.php";

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Report</h4>
                        <p class='category'>Relatórios do sistema</p>
                    </div>

                    <div class='content table-responsive'>
                        <form method="POST" name="form">                          
                            Report type:
                            <select class="form-control" name="reportsAvaliable">
                                <option value="reportNulo">Select a report</option>
                                <option value="report01">Gerencial</option>
                                <option value="report02">Livros e exemplares</option>
                                <option value="report03">Livros emprestados</option>
                                <option value="report04">Livros reservados</option>
                                <option value="report05">Usuários</option>
                                <option value="report06">Livros em atraso</option>
                            </select>
                            <br/>
                            Data Inicial:
                            <input type="text" id="dataInicio" name="dataInicio"/>

                            Data Final:
                            <input type="text" id="dataFinal" name="dataFinal"/>
                            <br/>
                            <br/>

                            <input class="btn btn-success" type="submit" value="GENERATE REPORT">
                            <hr>
                        </form>
                        
                        <?php
                        if (isset($_POST['reportsAvaliable'])){
                            $reportselected = $_POST['reportsAvaliable'];
                            $_SESSION['dtInicio'] = $_POST['dataInicio'];
                            $_SESSION['dtFim'] = $_POST['dataFinal'];
                            
                            if ($reportselected=="reportNulo"){ 
                                echo "Please, selected a report from the list above.";
                            }else { 
                                echo "<script>script:window.open('reports/".$reportselected.".php', '_blank');</script>";
                            }                        
                        }
                        ?>
                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$template->footer();
?>
