<?php

require_once 'db/connection.php';
require_once 'classes/reserva.php';

class reservaDAO
{
    public function remover($reserva){
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM reserva WHERE idReserva = :id");
            $statement->bindValue(":id", $reserva->getIdReserva());
            if ($statement->execute()) {
                return "<script> alert('Registro foi excluído com êxito !'); </script>";
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function salvar($reserva){
        global $pdo;
        try {

            $query = "SELECT idUsuario FROM usuario where Login=:id";
            $statement = $pdo->prepare($query);
            $statement->bindValue(":id", $reserva->getIdUsuario());
            if ($statement->execute()){
                $result = $statement->fetch(PDO::FETCH_OBJ);
                $idUser = $result->idUsuario;
            }

            if ($reserva->getIdReserva() != "") {
                $statement = $pdo->prepare("UPDATE reserva SET Livro_idLivro=:Livro_idLivro, EmprestimoSN=:EmprestimoSN, DataEmprestimo=:DataEmprestimo WHERE idReserva=:id");
                $statement->bindValue(":id", $reserva->getIdReserva());
                $statement->bindValue(":Livro_idLivro",$reserva->getIdLivro());
                $statement->bindValue(":EmprestimoSN",$reserva->getEmprestimoSN());
                $statement->bindValue(":DataEmprestimo",date("Y-m-d H:i:s"));
            } else {
                $statement = $pdo->prepare("INSERT INTO reserva (Usuario_idUsuario, Livro_idLivro, DataReserva, EmprestimoSN) VALUES (:Usuario_idUsuario,:Livro_idLivro,:DataReserva,:EmprestimoSN)");
                $statement->bindValue(":Usuario_idUsuario",$idUser);
                $statement->bindValue(":Livro_idLivro",$reserva->getIdLivro());
                $statement->bindValue(":DataReserva",date("Y-m-d H:i:s"));
                $statement->bindValue(":EmprestimoSN",$reserva->getEmprestimoSN());
            }

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> alert('Dados cadastrados com sucesso !'); </script>";
                } else {
                    return "<script> alert('Erro ao tentar efetivar cadastro !'); </script>";
                }
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }


    public function atualizar($reserva){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT idReserva, Usuario_idUsuario, Livro_idLivro, DataReserva, DataEmprestimo FROM reserva WHERE idReserva = :id");
            $statement->bindValue(":id", $reserva->getIdReserva());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $reserva->setIdReserva($rs->idReserva);
                $reserva->setIdLivro($rs->Livro_idLivro);

                return $reserva;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function tabelapaginada() {

        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 1);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */


        $sql = "SELECT r.idReserva, u.idUsuario, l.Titulo, r.DataReserva, r.EmprestimoSN 
                  FROM reserva r JOIN 
                       livro l on r.Livro_idLivro = l.idLivro JOIN 
                       usuario u on r.Usuario_idUsuario = u.idUsuario LIMIT {$linha_inicial}, " . QTDE_REGISTROS;


        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM reserva";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina  = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual -1 : 0 ;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 : 0 ;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1 ;

        /* Cálcula qual será a página final do nosso range */
        $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina ;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr style='text-transform: uppercase;' class='active'>
        <th style='text-align: center; font-weight: bolder;'>Codigo</th>
        <th style='text-align: center; font-weight: bolder;'>Usuario</th>
        <th style='text-align: center; font-weight: bolder;'>Livro</th>
        <th style='text-align: center; font-weight: bolder;'>Data reserva</th>
        <th style='text-align: center; font-weight: bolder;'>Status</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $reserva):


                echo "<tr>
        <td style='text-align: center'>$reserva->idReserva</td>
        <td style='text-align: center'>$reserva->idUsuario</td>
        <td style='text-align: center'>$reserva->Titulo</td>
        <td style='text-align: center'>$reserva->DataReserva</td>";
                if ($reserva->EmprestimoSN == 0)
                    echo"<td style='text-align: center'>Reservado</td>";
                if ($reserva->EmprestimoSN == 1)
                    echo"<td style='text-align: center'>Emprestado</td>";
           echo"<td style='text-align: center'><a href='?act=upd&id=$reserva->idReserva' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$reserva->idReserva' title='Remover'><i class='ti-close'></i></a></td>
       </tr>";
            endforeach;
            echo "
</tbody>
     </table>

     <div class='box-paginacao' style='text-align: center'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'> PRIMEIRA  |</a>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'> ANTERIOR  |</a>
";

            /* Loop para montar a páginação central com os números */
            for ($i = $range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'destaque' : '';
                echo "<a class='box-numero $destaque' href='$endereco?page=$i'> ( $i ) </a>";
            endfor;

            echo "<a class='box-navegacao $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'>| PRÓXIMA  </a>
                  <a class='box-navegacao $exibir_botao_final' href='$endereco?page=$ultima_pagina'  title='Última Página'>| ÚLTIMO  </a>
     </div>";
        else:
            echo "<p class='bg-danger'>Nenhum registro foi encontrado!</p>
     ";
        endif;

    }


}