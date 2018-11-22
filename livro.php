<?php

require_once 'classes/template.php';
require_once  'dao/livroDAO.php';
require_once 'classes/livro.php';

$object = new livroDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $titulo = (isset($_POST["titulo"]) && $_POST["titulo"] != null) ? $_POST["titulo"] : "";
    $ISBN = (isset($_POST["ISBN"]) && $_POST["ISBN"] != null) ? $_POST["ISBN"] : "";
    $autores = (isset($_POST["autores"]) && $_POST["autores"] != null) ? $_POST["autores"] : "";
    $edicao = (isset($_POST["edicao"]) && $_POST["edicao"] != null) ? $_POST["edicao"] : "";
    $editora = (isset($_POST["editora"]) && $_POST["editora"] != null) ? $_POST["editora"] : "";
    $ano = (isset($_POST["ano"]) && $_POST["ano"] != null) ? $_POST["ano"] : "";
    $fk_idCategoria = (isset($_POST["fk_idCategoria"]) && $_POST["fk_idCategoria"] != null) ? $_POST["fk_idCategoria"] : "";

} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $titulo = NULL;
    $ISBN = NULL;
    $autores = NULL;
    $edicao = NULL;
    $editora = NULL;
    $ano = NULL;
    $fk_idCategoria = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $livro = new livro($id,'','','','','','','','');

    $resultado = $object->atualizar($livro);
    $titulo = $resultado->getTitulo();
    $ISBN = $resultado->getISBN();
    $autores = $resultado->getAutores();
    $edicao = $resultado->getEdicao();
    $editora = $resultado->getEditora();
    $ano = $resultado->getAno();
    $fk_idCategoria = $resultado->getFkIdCategoria();


}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $titulo != "" && $ISBN != "" &&
    $autores != "" && $edicao != "" && $editora != "" && $ano != "" && $fk_idCategoria != "")
{
    $livro = new livro($id,$titulo, $ISBN, $autores, $edicao, $editora, $ano, $fk_idCategoria);
    $msg = $object->salvar($livro);
    $id = null;
    $titulo = NULL;
    $ISBN = NULL;
    $autores = NULL;
    $edicao = NULL;
    $editora = NULL;
    $ano = NULL;
    $fk_idCategoria = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $livro = new livro($id,'', '', '', '', '', '','','');
    $msg = $object->remover($livro);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Cadastro de Livros</h4>
                        <p class='category'>Lista e Cadastro de Livros</p>

                    </div>

                    <div class='content table-responsive'>
                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Titulo:
                            <input class="form-control" type="text" name="titulo" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($titulo) && ($titulo != null || $titulo != "")) ? $titulo : '';
                            ?>"/>
                            <br/>
                            ISBN:
                            <input class="form-control" type="text" name="ISBN" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($ISBN) && ($ISBN != null || $ISBN != "")) ? $ISBN : '';
                            ?>"/>
                            <br/>
                            Autores:
                            <input class="form-control" type="text" name="autores" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($autores) && ($autores != null || $autores != "")) ? $autores : '';
                            ?>"/>
                            <br/>

                            Edição:
                            <input class="form-control" type="text" name="edicao" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($edicao) && ($edicao != null || $edicao != "")) ? $edicao : '';
                            ?>"/>
                            <br/>

                            Editora:
                            <input class="form-control" type="text" name="editora" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($editora) && ($editora != null || $editora != "")) ? $editora : '';
                            ?>"/>
                            <br/>

                            Ano:
                            <input class="form-control" type="number"  name="ano" placeholder="YYYY" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($ano) && ($ano != null || $ano != "")) ? $ano : '';
                            ?>"/>
                            <br/>


                            Categoria:
                            <select class="form-control" name="fk_idCategoria">
                                <?php
                                $query = "SELECT * FROM categoria order by Nome;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        echo "<option value='$rs->idCategoria'>$rs->nome</option>";
//                                        if ($rs->idCategoria == $fk_idCategoria) {
//                                            echo "<option value='$rs->idCategoria' selected>$rs->nome</option>";
//                                        } else {
//                                            echo "<option value='$rs->idCategoria'>$rs->nome</option>";
//                                        }
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


