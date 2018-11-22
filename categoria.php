<?php

require_once 'classes/template.php';
require_once 'dao/categoriaDAO.php';
require_once 'classes/categoria.php';

$object = new categoriaDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $descricao = (isset($_POST["descricao"]) && $_POST["descricao"] != null) ? $_POST["descricao"] : "";
	$assunto = (isset($_POST["assunto"]) && $_POST["assunto"] != null) ? $_POST["assunto"] : "";

}else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $descricao = NULL;
	$assunto = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $categoria = new categoria($id,'','','');

    $resultado = $object->atualizar($categoria);
    $nome = $resultado->getNome();
    $descricao = $resultado->getDescricao();
	$assunto = $resultado->getAssunto();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "" && $descricao != "")
{
    $categoria = new categoria($id, $nome, $descricao,$assunto);
    $msg = $object->salvar($categoria);
    $id = null;
    $nome = NULL;
    $descricao = NULL;
	$assunto = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $categoria = new categoria($id, '', '','');
    $msg = $object->remover($categoria);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Cadastro de Categoria</h4>
                        <p class='category'>Cadastro de categoria dos Livros!</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>

                            Nome:
                            <input class="form-control" type="text" name="nome" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                            ?>"/>
                            <br/>

                            Descrição:
                            <input class="form-control" type="text" name="descricao" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($descricao) && ($descricao != null || $descricao != "")) ? $descricao : '';
                            ?>"/>
                            <br/>
							
							Assunto:
                            <input class="form-control" type="text" name="assunto" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($assunto) && ($assunto != null || $assunto != "")) ? $assunto : '';
                            ?>"/>
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
