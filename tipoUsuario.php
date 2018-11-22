<?php

require_once 'classes/template.php';
require_once 'dao/tipoUsuarioDAO.php';
require_once 'classes/tipoUsuario.php';

$object = new tipoUsuarioDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $descricao = (isset($_POST["descricao"]) && $_POST["descricao"] != null) ? $_POST["descricao"] : "";

}else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $descricao = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $tipoUsuario = new tipoUsuario($id,'');

    $resultado = $object->atualizar($tipoUsuario);
    $tipoUsuario = $resultado->getDescricao();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $descricao != "")
{
    $tipoUsuario = new tipoUsuario($id, $descricao);
    $msg = $object->salvar($tipoUsuario);
    $id = null;
    $descricao = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $tipoUsuario = new tipoUsuario($id, '');
    $msg = $object->remover($tipoUsuario);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Cadastro de Perfil de Usuario</h4>
                        <p class='category'>Cadastro de Perfil de Usuário!</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>

                            Descrição:
                            <input class="form-control" type="text" name="descricao" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($descricao) && ($descricao != null || $descricao != "")) ? $descricao : '';
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
