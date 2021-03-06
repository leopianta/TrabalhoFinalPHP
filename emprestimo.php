<?php

require_once 'classes/template.php';
require_once 'dao/emprestimoDAO.php';
require_once 'classes/emprestimo.php';

$object = new emprestimoDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $idReserva = (isset($_POST["fk_idLivro"]) && $_POST["fk_idLivro"] != null) ? $_POST["fk_idLivro"] : "";

}else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $idReserva = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $emprestimo = new emprestimo($id,'','');

    $resultado = $object->atualizar($emprestimo);
    $idReserva = $resultado->getIdReserva();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save")
{
    $emprestimo = new emprestimo($id,$idReserva,$_SESSION['login'],$idExemplar);
    $msg = $object->salvar($emprestimo);
    $id = null;
    $idReserva = Null;
    $idExemplar = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $emprestimo = new emprestimo($id,$idReserva,$_SESSION['login'],$idExemplar);
    $msg = $object->remover($emprestimo);
    $id = null;
    $idExemplar = null;
    $idReserva = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Realização de Emprestimo</h4>
                        <p class='category'>Realização de Emprestimo!</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="idEmprestimo" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>

                            Reservas realizadas:
                            <select class="form-control" name="fk_idLivro">
                                <?php
                                $query = "SELECT Titulo FROM reserva r JOIN Livro l on r.Livro_idLivro = l.idLivro order by titulo;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->idLivro == $fk_idLivro) {
                                            echo "<option value='$rs->idReserva' selected>$rs->Titulo</option>";
                                        } else {
                                            echo "<option value='$rs->idReserva'>$rs->Titulo</option>";
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
