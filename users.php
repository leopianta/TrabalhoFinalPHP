<?php

require_once "classes/template.php";

require_once "dao/userDAO.php";
require_once "classes/user.php";

$object = new userDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();

$p = $_SESSION['tipoUsuario'];

//perfil: 0:Adm, 1:User
//Se o perfil for diferente de Adm e for digitado o endereço no browse, redireciona o usuario para o index.
if($p != 0){
     echo "<script>script:window.open('index.php', '_self');</script>";
}
// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $login = (isset($_POST["login"]) && $_POST["login"] != null) ? $_POST["login"] : "";
    $senha = (isset($_POST["senha"]) && $_POST["senha"] != null) ? $_POST["senha"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $tipoUsuario = (isset($_POST["tipoUsuario"]) && $_POST["tipoUsuario"] != null) ? $_POST["tipoUsuario"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $login = null;
    $senha = null;
    $nome = null;
    $tipoUsuario = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $user = new user($id, "", "", "", "", "", "");

    $resultado = $object->atualizar($user);
    $login = $resultado->getLogin();
    $senha = $resultado->getSenha();
    $nome = $resultado->getNome();
    $tipoUsuario = $resultado->getTipoUsuario();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" &&
        $login != "" && $senha != "" && $nome != "" && $tipoUsuario != "")
{
    $user = new user($id, $login, $senha, $nome, $tipoUsuario);
    //var_dump($id);
    //var_dump($login);
    //echo $login;
    $msg = $object->salvar($user);
    $id = null;
    $login = null;
    $senha = null;
    $nome = null;
    $tipoUsuario = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $user = new user($id, "", "", "", "", "", "");

    $msg = $object->remover($user);
    $id = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Users</h4>
                        <p class='category'>List of system users</p>

                    </div>
                    <div class='content table-responsive'>
                    <?php
                        if($p == 1){
                            $object->tabelapaginada();
                        }
                    ?>
                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            <Laber>Name</Laber>
                            <input class="form-control" type="<?php echo ($p == 0) ? 'text' : 'hidden' ?>" size="50" name="nome" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                            ?>"/>
                            <br/>
                            <Laber>Login</Laber>
                            <input class="form-control" type="<?php echo ($p == 0) ? 'text' : 'hidden' ?>" size="50" name="login" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($login) && ($login != null || $login != "")) ? $login : '';
                            ?>" required/>
                            <br/>
                            <Laber>Senha</Laber>
                            <input class="form-control" type="<?php echo ($p == 0) ? 'text' : 'hidden' ?>" size="10" name="senha" value="<?php
                                   // Preenche o sigla no campo sigla com um valor "value"
                                   //echo (isset($senha) && ($senha != null || $senha != "")) ? $senha : '';
                                   ?>" required/>
                            <br/>
                            <Laber>Tipo de usuario</Laber>
                            <?php 
                                if($p == 0){
                                    echo "<select class='form-control' name='tipoUsuario'>
                                    <option value='1'"; 
                                    if(isset($tipoUsuario) && ($tipoUsuario != null || $tipoUsuario != ""))
                                        echo (($tipoUsuario == 1) ? ' selected' : '');
                                    echo ">Usuario</option>";
                                    echo "<option value='0'"; 
                                    if(isset($tipoUsuario) && ($tipoUsuario != null || $tipoUsuario != ""))
                                        echo (($tipoUsuario == 0) ? ' selected' : '');
                                    echo ">Administrador</option></select>";
                                }
                            ?>
                            
                            <br/>

                            <input class="btn btn-success" type="<?php echo ($p == 0) ? 'submit' : 'hidden' ?>" value="REGISTER">
                                <hr>
                                    </form>
                                <?php
                                    if($p == 0){   
                                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
                                        //chamada a paginação
                                        $object->tabelapaginada();
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
