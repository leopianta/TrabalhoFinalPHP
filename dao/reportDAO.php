<?php

require_once "../db/connection.php";
//require_once "../classes/beneficiaries.php";

class reportDAO
{

    public function report01()
    {
        session_start();
        global $pdo;
        $dtInicio = $_SESSION['dtInicio'];
        $dtFim = $_SESSION['dtFim'];
        try {
            $statement = $pdo->prepare('Select l.idLivro, l.Titulo, l.isbn, e.Exemplarcol as Exemplares,
                                                           r.DataReserva, r.DataEmprestimo,
                                                          (SELECT Count(re.EmprestimoSN) 
                                                             FROM reserva re 
                                                            WHERE re.Livro_idLivro = l.idLivro 
                                                              AND re.EmprestimoSN = 0) as totalReservados,
                                                          (SELECT Count(re.EmprestimoSN) 
                                                             FROM reserva re 
                                                            WHERE re.Livro_idLivro = l.idLivro 
                                                            AND re.EmprestimoSN = 1) as totalEmprestados
                                                      from livro l JOIN 
                                                           reserva r on l.idLivro = r.Livro_idLivro JOIN 
                                                           exemplar e on l.idLivro  = e.Livro_idLivro
                                                     Where r.DataReserva between '.$dtInicio.' and '.$dtFim.'
                                                     Group By l.idLivro');


            var_dump($statement);

            if ($statement->execute()) {
                $list = $statement->fetchAll(PDO::FETCH_OBJ);
                return $list;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function report02()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('  SELECT l.idLivro, l.Titulo, l.isbn, e.Exemplarcol AS Exemplares
                                                      FROM livro l JOIN
                                                           exemplar e ON l.idLivro = e.Livro_idLivro
                                                  GROUP BY l.idLivro;');
            if ($statement->execute()) {
                $list = $statement->fetchAll(PDO::FETCH_OBJ);
                return $list;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

        public function report03()
        {
            global $pdo;
            try {
                $statement = $pdo->prepare('SELECT l.idLivro, l.Titulo, l.isbn, e.Nome
                                                        FROM livro l JOIN
                                                             reserva r ON l.idLivro = r.Livro_idLivro JOIN editora e on l.Editora_idEditora = e.idEditora
                                                       WHERE r.emprestimoSN = 0
                                                    GROUP BY l.idLivro;');
                if ($statement->execute()) {
                    $list = $statement->fetchAll(PDO::FETCH_OBJ);
                    return $list;
                }else {
                    throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
                }
            }catch (PDOException $erro) {
                return "Erro: " . $erro->getMessage();
            }
        }

    public function report04()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT l.idLivro, l.Titulo, l.isbn, e.Nome
                                                        FROM livro l JOIN
                                                             reserva r ON l.idLivro = r.Livro_idLivro JOIN editora e on l.Editora_idEditora = e.idEditora
                                                       WHERE r.emprestimoSN = 1
                                                    GROUP BY l.idLivro;");
            if ($statement->execute()) {
                $list = $statement->fetchAll(PDO::FETCH_OBJ);
                return $list;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

            public function report05()
            {
                global $pdo;
                try {
                    $statement = $pdo->prepare('SELECT u.Nome, u.Login, tp.descricao 
                                                            FROM usuario u JOIN 
                                                                 tipoUsuario tp ON u.TipoUsuario_idTipoUsuario = tp.idTipoUsuario;');
                    if ($statement->execute()) {
                        $list = $statement->fetchAll(PDO::FETCH_OBJ);
                        return $list;
                    }else {
                        throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
                    }
                }catch (PDOException $erro) {
                    return "Erro: " . $erro->getMessage();
                }
            }


/*
            public function report06()
            {
                global $pdo;
                try {
                    $statement = $pdo->prepare('SELECT sum(db_value) valor, str_name_region nome FROM db_eca.tb_payments, tb_city, tb_state, tb_region where tb_payments.id_payment = tb_city.id_city and tb_city.tb_state_id_state = tb_state.id_state and tb_state.tb_region_id_region = tb_region.id_region group by tb_region.id_region order by tb_state.str_name;');
                    if ($statement->execute()) {
                        $list = $statement->fetchAll(PDO::FETCH_OBJ);
                        return $list;
                    }else {
                        throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
                    }
                }catch (PDOException $erro) {
                    return "Erro: " . $erro->getMessage();
                }
            }

            public function report07()
            {
                global $pdo;
                try {
                    $statement = $pdo->prepare('SELECT sum(db_value) valor, str_name FROM db_eca.tb_payments, tb_city, tb_state where tb_payments.id_payment = tb_city.id_city and tb_city.tb_state_id_state = tb_state.id_state group by tb_state.id_state order by tb_state.str_name;');
                    if ($statement->execute()) {
                        $list = $statement->fetchAll(PDO::FETCH_OBJ);
                        return $list;
                    }else {
                        throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
                    }
                }catch (PDOException $erro) {
                    return "Erro: " . $erro->getMessage();
                }
            }
        */
    public function dateNow(){
        date_default_timezone_set('America/Sao_Paulo');
        $obj = date('d-m-Y');
        return $obj;
    }   
    
    public function hourNow(){
        date_default_timezone_set('America/Sao_Paulo');
        $hour = date('H:i');
        return $hour;
    }  
}
