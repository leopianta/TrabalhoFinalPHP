<?php

require_once "classes/template.php";
require_once "dao/cropGuaranteeDAO.php";
require_once "classes/cropGuarantee.php";

$object = new cropGuaranteeDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $str_month = (isset($_POST["str_month"]) && $_POST["str_month"] != null) ? $_POST["str_month"] : "";
    $str_year = (isset($_POST["str_year"]) && $_POST["str_year"] != null) ? $_POST["str_year"] : "";
    $tb_city_id_city = (isset($_POST["tb_city_id_city"]) && $_POST["tb_city_id_city"] != null) ? $_POST["tb_city_id_city"] : "";
    $tb_beneficiaries_id_beneficiaries = (isset($_POST["tb_beneficiaries_id_beneficiaries"]) && $_POST["tb_beneficiaries_id_beneficiaries"] != null) ? $_POST["tb_beneficiaries_id_beneficiaries"] : "";
    $db_value = (isset($_POST["db_value_service"]) && $_POST["db_value_service"] != null) ? $_POST["db_value_service"] : "";
} else if (!isset($id)) {
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $str_month = NULL;
    $str_year = NULL;
    $tb_city_id_city = NULL;
    $tb_beneficiaries_id_beneficiaries = NULL;
    $db_value = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $cropGuarantee = new cropGuarantee($id,'','','','','');

    $resultado = $object->atualizar($cropGuarantee);
    $str_month = $resultado->getStrMonth();
    $str_year = $resultado->getStrYear();
    $tb_city_id_city = $resultado->getTbCityIdCity();
    $tb_beneficiaries_id_beneficiaries = $resultado->getTbBeneficiariesIdBeneficiaries();
    $db_value = $resultado->getDbValue();

}

if (isset($_REQUEST["act"]) &&  $_REQUEST["act"] == "save" && $str_month != "" && $str_year != "" && $tb_city_id_city != "" && $tb_beneficiaries_id_beneficiaries != "" &&
    $db_value != "")
{
    $cropGuarantee = new cropGuarantee($id, $str_month, $str_year, $db_value, $tb_city_id_city, $tb_beneficiaries_id_beneficiaries);
    $msg = $object->salvar($cropGuarantee);
    $id = null;
    $str_month = null;
    $str_year =  null;
    $tb_city_id_city =  null;
    $tb_beneficiaries_id_beneficiaries = null;
    $db_value = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $cropGuarantee = new cropGuarantee($id,'','','','','','');
    $msg = $object->remover($cropGuarantee);
    $id= null;
}

?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Crop Guarantee</h4>
                            <p class='category'>List of Crop Guarantee of the system</p>

                        </div>
                        <div class='content table-responsive'>

                            <form action="?act=save&id=" method="POST" name="form1">

                                <input type="hidden" name="id" value="<?php
                                // Preenche o id no campo id com um valor "value"
                                echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                                ?>"/>
                                Month:
                                <input class="form-control" type="number" min="1" max="12" maxlength="2" name="str_month" placeholder="MM" value="<?php
                                // Preenche o nome no campo nome com um valor "value"
                                echo (isset($str_month) && ($str_month != null || $str_month != "")) ? $str_month : '';
                                ?>"/>
                                <br/>
                                Year:
                                <input class="form-control" type="number" min="1" max="<?php echo date('Y');?>" maxlength="4" name="str_year" placeholder="YYYY" value="<?php
                                // Preenche o sigla no campo sigla com um valor "value"
                                echo (isset($str_year) && ($str_year != null || $str_year != "")) ? $str_year : '';
                                ?>"/>
                                City:
                                <select class="form-control" name="tb_city_id_city">
                                    <?php
                                    $query = "SELECT * FROM tb_city order by str_name_city;";
                                    $statement = $pdo->prepare($query);
                                    if ($statement->execute()) {
                                        $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($result as $rs) {
                                            if ($rs->id_city == $tb_city_id_city) {
                                                echo "<option value='$rs->id_city' selected>$rs->str_name_city</option>";
                                            } else {
                                                echo "<option value='$rs->id_city'>$rs->str_name_city</option>";
                                            }
                                        }
                                    } else {
                                        throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                    }
                                    ?>
                                </select>
                                <br/>

                                Beneficiarie:
                                <select class="form-control" name="tb_beneficiaries_id_beneficiaries">
                                    <?php
                                    $query = "SELECT * FROM tb_beneficiaries order by str_name_person;";
                                    $statement = $pdo->prepare($query);
                                    if ($statement->execute()) {
                                        $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($result as $rs) {
                                            if ($rs->id_beneficiaries == $tb_beneficiaries_id_beneficiaries) {
                                                echo "<option value='$rs->id_beneficiaries' selected>$rs->str_name_person</option>";
                                            } else {
                                                echo "<option value='$rs->id_beneficiaries'>$rs->str_name_person</option>";
                                            }
                                        }
                                    } else {
                                        throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                    }
                                    ?>
                                </select>
                                <br/>

                                Value:
                                <input class="form-control" type="number" name="db_value_service" value="<?php
                                // Preenche o sigla no campo sigla com um valor "value"
                                echo (isset($db_value_service) && ($db_value_service != null || $db_value_service != "")) ? $db_value_service : '';
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