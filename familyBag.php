<?php

require_once "classes/template.php";
require_once "dao/familyBagDAO.php";
require_once "classes/familyBag.php";

$object = new familyBagDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $str_month = (isset($_POST["str_month"]) && $_POST["str_month"] != null) ? $_POST["str_month"] : "";
    $str_year = (isset($_POST["str_year"]) && $_POST["str_year"] != null) ? $_POST["str_year"] : "";
    $str_month_reference = (isset($_POST["str_month_reference"]) && $_POST["str_month_reference"] != null) ? $_POST["str_month_reference"] : "";
    $str_year_reference = (isset($_POST["str_year_reference"]) && $_POST["str_year_reference"] != null) ? $_POST["str_year_reference"] : "";
    $tb_city_id_city = (isset($_POST["tb_city_id_city"]) && $_POST["tb_city_id_city"] != null) ? $_POST["tb_city_id_city"] : "";
    $tb_beneficiaries_id_beneficiaries = (isset($_POST["tb_beneficiaries_id_beneficiaries"]) && $_POST["tb_beneficiaries_id_beneficiaries"] != null) ? $_POST["tb_beneficiaries_id_beneficiaries"] : "";
    $str_date_service = (isset($_POST["str_date_service"]) && $_POST["str_date_service"] != null) ? $_POST["str_date_service"] : "";
    $db_value_service = (isset($_POST["db_value_service"]) && $_POST["db_value_service"] != null) ? $_POST["db_value_service"] : "";
} else if (!isset($id)) {
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $str_month = NULL;
    $str_year = NULL;
    $str_month_reference = NULL;
    $str_year_reference = NULL;
    $tb_city_id_city = NULL;
    $tb_beneficiaries_id_beneficiaries = NULL;
    $str_date_service = NULL;
    $db_value_service = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $familyBag = new familyBag($id,'','','','','','','','');

    $resultado = $object->atualizar($familyBag);
    $str_month = $resultado->getStrMonth();
    $str_year = $resultado->getStrYear();
    $str_month_reference = $resultado->getStrMonthReference();
    $str_year_reference = $resultado->getStrYearReference();
    $tb_city_id_city = $resultado->getTbCityIdCity();
    $tb_beneficiaries_id_beneficiaries = $resultado->getTbBeneficiariesIdBeneficiaries();
    $str_date_service = $resultado->getStrDateService();
    $db_value_service = $resultado->getDbValueService();

}

if (isset($_REQUEST["act"]) &&  $_REQUEST["act"] == "save" && $str_month != "" && $str_year != "" &&
    $str_month_reference != "" && $str_year_reference != "" && $tb_city_id_city != "" && $tb_beneficiaries_id_beneficiaries != "" &&
    $str_date_service != "" && $db_value_service != "")
{
    $familyBag = new familyBag($id, $str_month, $str_year, $str_month_reference, $str_year_reference, $tb_city_id_city, $tb_beneficiaries_id_beneficiaries, $str_date_service, $db_value_service);
    $msg = $object->salvar($familyBag);
    $id = null;
    $str_month = null;
    $str_year =  null;
    $str_month_reference =  null;
    $str_year_reference =  null;
    $tb_city_id_city =  null;
    $tb_beneficiaries_id_beneficiaries = null;
    $str_date_service =  null;
    $db_value_service = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $familyBag = new familyBag($id,'','','','','','','','');
    $msg = $object->remover($familyBag);
    $id= null;
}

?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>FamilyBag</h4>
                            <p class='category'>List of familyBag of the system</p>

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
                                Month Reference:
                                <input class="form-control" type="number" min="1" max="12" maxlength="2" name="str_month_reference" placeholder="MM" value="<?php
                                // Preenche o nome no campo nome com um valor "value"
                                echo (isset($str_month_reference) && ($str_month_reference != null || $str_month_reference != "")) ? $str_month_reference : '';
                                ?>"/>
                                <br/>
                                Year Reference:
                                <input class="form-control" type="number" min="1" max="<?php echo date('Y');?>" maxlength="4" name="str_year_reference" placeholder="YYYY" value="<?php
                                // Preenche o sigla no campo sigla com um valor "value"
                                echo (isset($str_year_reference) && ($str_year_reference != null || $str_year_reference != "")) ? $str_year_reference : '';
                                ?>"/>
                                <br/>
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

                                Data Service:
                                <input class="form-control" type="text" name="str_date_service" value="<?php
                                // Preenche o sigla no campo sigla com um valor "value"
                                echo (isset($str_date_service) && ($str_date_service != null || $str_date_service != "")) ? $str_date_service : '';
                                ?>"/>
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