<?php

require_once "db/connection.php";

session_start();
$login = $_POST['login'];
$passwd = $_POST['password'];
$idUsuario = null;
$name = null;
$login = null;
$pass = null; 
$tipoUsuario = null;

try {

    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM usuario WHERE Login = :login and Senha = :password; ");
    $statement->bindValue(":login", $login);
    $statement->bindValue(":password", sha1($passwd));
    if ($statement->execute()) {
        $rs = $statement->fetch(PDO::FETCH_OBJ);
        
        $iduser = $rs->idUsuario;
        $login = $rs->login;
        $name = $rs->nome;
        $pass = $rs->senha;
        $tipoUsuario = $rs->perfil;
        
        if( $login != null and $pass != null)
        {
            $_SESSION['idUsuario'] = $idUsuario;
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $pass;
            $_SESSION['name'] = $name;
            $_SESSION['tipoUsuario'] = $tipoUsuario;
            
            header('location:index.php');
        }
        else{
            unset ($_SESSION['iduser']);
            unset ($_SESSION['login']);
            unset ($_SESSION['password']);
            unset ($_SESSION['name']);
            unset ($_SESSION['perfil']);
            echo "<script> alert('Usuario ou pass incorretos !'); </script>";
            
            header('location:index.php');

        }
    } else {
        throw new PDOException("Erro: Não foi possível executar a declaração sql");
    }
} catch (PDOException $erro) {
    echo "Erro: ".$erro->getMessage();
}

?>