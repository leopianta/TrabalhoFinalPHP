<?php

require_once 'db/connection.php';
require_once 'classes/emprestimo.php';

class emprestimoDAO
{
    public function remover($emprestimo){
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM emprestimo WHERE idEmprestimo = :id");
            $statement->bindValue(":id", $emprestimo->getIdEmprestimo());
            $statement->bindValue(":Usuario_idUsuario", $emprestimo->getIdUsuario());
            $statement->bindValue(":Exemplar_idExemplar", $emprestimo->getIdExemplar());
            $statement->bindValue(":Reserva_idReserva", $emprestimo->getIdReserva());
            if ($statement->execute()) {
                return "<script> alert('Registro foi excluído com êxito !'); </script>";
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function salvar($emprestimo){
        global $pdo;
        try {
            if ($emprestimo->getIdEmprestimo() != "") {
                $statement = $pdo->prepare("UPDATE emprestimo SET Livro_idLivro=:idLivro WHERE idEmprestimo = :id;");
                $statement->bindValue(":id", $emprestimo->getIdEmprestimo());
            } else {
                $statement = $pdo->prepare("INSERT INTO emprestimo (Usuario_idUsuario, Exemplar_idExemplar, Reserva_idReserva, DataEmprestimo) VALUES (:Usuario_idUsuario, :Exemplar_idExemplar, :Reserva_idReserva, :DataEmprestimo)");
                $statement->bindValue(":Exemplar_idExemplar",$emprestimo->getIdExemplar());
                $statement->bindValue(":Reserva_idReserva",$emprestimo->getIdReserva());
                $statement->bindValue(":Usuario_idUsuario",$emprestimo->getIdUsuario());
                $statement->bindValue(":DataEmprestimo",date("Y-m-d H:i:s"));
            }


            var_dump($statement);
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


    public function atualizar($emprestimo){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT * FROM emprestimo 
                                                          WHERE idEmprestimo = :id");
            $statement->bindValue(":id", $emprestimo->getIdEmprestimo());
            $statement->bindValue(":Usuario_idUsuario", $emprestimo->getIdUsuario());
            $statement->bindValue(":Exemplar_idExemplar", $emprestimo->getIdExemplar());
            $statement->bindValue(":Reserva_idReserva", $emprestimo->getIdReserva());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $emprestimo->setIdEmprestimo($emprestimo->idEmprestimo);
                $emprestimo->setIdUsuario($rs->Usuario_idUsuario);
                $emprestimo->setIdExemplar($rs->Exemplar_idExemplar);
                $emprestimo->setIdReserva($rs->Reserva_idReserva);

                return $emprestimo;
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


        $sql = "SELECT e.idEmprestimo, u.idUsuario, l.Titulo, e.DataEmprestimo
                  FROM emprestimo e JOIN 
                       livro l on r.Livro_idLivro = l.idLivro JOIN 
                       usuario u on e.Usuario_idUsuario = u.idUsuario LIMIT {$linha_inicial}, " . QTDE_REGISTROS;

        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM emprestimo";
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
        <th style='text-align: center; font-weight: bolder;'>Usuario</th>
        <th style='text-align: center; font-weight: bolder;'>Livro</th>
        <th style='text-align: center; font-weight: bolder;'>Data</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $emprestimo):


                echo "<tr>
        <td style='text-align: center'>$emprestimo->idAutor</td>
        <td style='text-align: center'>$emprestimo->nome</td>
           <td style='text-align: center'><a href='?act=upd&id=$emprestimo->idEmprestimo' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$emprestimo->idEmprestimo' title='Remover'><i class='ti-close'></i></a></td>
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