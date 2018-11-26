<?php

require_once 'classes/template.php';
require_once 'dao/exemplarDAO.php';
require_once 'classes/exemplar.php';

$object = new exemplarDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $quant = (isset($_POST["quant"]) && $_POST["quant"] != null) ? $_POST["quant"] : "";
    $AcervoDigitalSN = (isset($_POST["AcervoDigitalSN"]) && $_POST["AcervoDigitalSN"] != null) ? $_POST["AcervoDigitalSN"] : "";
    $arquivo = (isset($_POST["arquivo"]) && $_POST["arquivo"] != null) ? $_POST["arquivo"] : "";
    $emprestimo_consulta = (isset($_POST["emprestimo_consulta"]) && $_POST["emprestimo_consulta"] != null) ? $_POST["emprestimo_consulta"] : "";
    $fk_idLivro = (isset($_POST["fk_idLivro"]) && $_POST["fk_idLivro"] != null) ? $_POST["fk_idLivro"] : "";


} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $quant = NULL;
    $AcervoDigitalSN = NULL;
    $arquivo = NULL;
    $emprestimo_consulta = NULL;
    $fk_idLivro = NULL;
}


if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $exemplar = new exemplar($id, '', '', '', '', '');

    $resultado = $object->atualizar($exemplar);
    $quant = $resultado->getQuant();
    $AcervoDigitalSN = $resultado->getDigitalFisico();
    $arquivo = $resultado->getArquivo();
    $emprestimo_consulta = $resultado->getEmprestimoConsulta();
    $fk_idLivro = $resultado->getFkIdLivro();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $quant != "" && $AcervoDigitalSN != ""
    && $emprestimo_consulta != "" && $fk_idLivro != "") {
    $size = $_FILES['arquivo']['size'];

    if ($size > 0) {
        $ext = strtolower(substr($_FILES['arquivo']['name'], -4)); //Pegando extensão do arquivo
        $novo_nome = md5(time()) . $ext; //Definindo um novo nome para o arquivo
        $dir = 'arquivo/'; //Diretório para uploads

        move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir . $novo_nome); //Fazer upload do arquivo
    } else {
        $novo_nome = "-";
    }

    $exemplar = new exemplar($id, $quant, $digital_fisico, $novo_nome, $emprestimo_consulta, $fk_idLivro);
    $msg = $object->salvar($exemplar);
    $id = null;
    $quant = NULL;
    $digital_fisico = NULL;
    $novo_nome = NULL;
    $emprestimo_consulta = NULL;
    $fk_idLivro = NULL;

}


if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $exemplar = new exemplar($id, '', '', '', '', '');
    $msg = $object->remover($exemplar);
    $id = null;
}


?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Cadastro de Exemplares</h4>
                        <p class='category'>Cadastro de exemplares dos Livros!</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1" enctype="multipart/form-data">

                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>


                            Exemplares:
                            <input class="form-control" type="number" name="quant" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($quant) && ($quant != null || $quant != "")) ? $quant : '';
                            ?>"/>
                            <br/>


                            Acervo Digital:
                            <select class="form-control" name="AcervoDigitalSN" id="AcervoDigitalSN">
                                <option value="0" <?php if (isset($digital_fisico) && $digital_fisico == "0") echo 'selected' ?>>
                                    Sim
                                </option>
                                <option value="1" <?php if (isset($digital_fisico) && $digital_fisico == "1") echo 'selected' ?>>
                                    Não
                                </option>
                            </select>
                            <br/>

                            <div id="divUpload" style="">
                                Arquivo:
                                <input class="form-control" type="file" name="arquivo" value="<?php
                                // Preenche o nome no campo nome com um valor "value"
                                echo (isset($arquivo) && ($arquivo != null || $arquivo != "")) ? $arquivo : '';
                                ?>"/>
                                <br/>
                            </div>

                            Livro:
                            <select class="form-control" name="fk_idLivro">
                                <?php
                                $query = "SELECT * FROM livro order by titulo;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->idLivro == $fk_idLivro) {
                                            echo "<option value='$rs->idLivro' selected>$rs->Titulo</option>";
                                        } else {
                                            echo "<option value='$rs->idLivro'>$rs->Titulo</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            <input class="btn btn-success" type="submit" value="REGISTER">
                            <hr>
                        </form>


                        <?php
                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
                        //chamada a paginação
                        $object->tabelapaginada();

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
