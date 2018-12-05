<?php

require_once 'db/connection.php';
require_once 'classes/exemplar.php';

class exemplarDAO
{
    public function remover($exemplar){
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM exemplar WHERE idExemplar = :id");
            $statement->bindValue(":id", $exemplar->getIdExemplar());
            if ($statement->execute()) {
                return "<script> alert('Registo foi excluído com êxito !'); </script>";
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function salvar($exemplar){
        global $pdo;
        try {
            if ($exemplar->getIdExemplar() != "") {
                $statement = $pdo->prepare("UPDATE exemplar SET Exemplarcol=:ExemplarQtde, AcervoDigitalSN=:AcervoDigitalSN, UploadArquivo=:UploadArquivo, Livro_idLivro=:Livro_idLivro WHERE idExemplar = :id;");
                $statement->bindValue(":id", $exemplar->getIdExemplar());

            } else {
                $statement = $pdo->prepare("INSERT INTO exemplar (UploadArquivo, AcervoDigitalSN, Exemplarcol, Livro_idLivro) VALUES (:UploadArquivo, :AcervoDigitalSN, :ExemplarQtde, :Livro_idLivro)");
            }


            $statement->bindValue(":UploadArquivo",$exemplar->getUploadArquivo());
            $statement->bindValue(":AcervoDigitalSN",$exemplar->getAcervoDigitalSN());
            $statement->bindValue(":ExemplarQtde",$exemplar->getExemplarQtde());
            $statement->bindValue(":Livro_idLivro",$exemplar->getFkIdLivro());

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

    public function atualizar($exemplar){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT idExemplar, UploadArquivo, AcervoDigitalSN, Exemplarcol, Livro_idLivro FROM exemplar WHERE idExemplar = :id");
            $statement->bindValue(":id", $exemplar->getIdExemplar());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $exemplar->setIdExemplar($rs->idExemplar);
                $exemplar->setAcervoDigitalSN($rs->AcervoDigitalSN);
                $exemplar->setUploadArquivo($rs->UploadArquivo);
                $exemplar->setExemplarQtde($rs->Exemplarcol);
                $exemplar->setFkIdLivro($rs->Livro_idLivro);


                return $exemplar;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function countAll()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT count(*) AS countAll FROM exemplar;');
            if ($statement->execute()) {
                $rs = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rs as $value) {
                    if($value['countAll'])
                        $countAll = $value['countAll'];
                }
                return $countAll;
            }else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
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


        $sql = "SELECT e.idExemplar, e.AcervoDigitalSN, e.UploadArquivo, e.Exemplarcol as Exemplares, l.Titulo
                  FROM exemplar e JOIN 
                       Livro l on e.Livro_idLivro = l.idLivro; LIMIT {$linha_inicial}, " . QTDE_REGISTROS;


        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM exemplar";
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
        <th style='text-align: center; font-weight: bolder;'>Exemplares</th>
        <th style='text-align: center; font-weight: bolder;'>Digital ou Fisico</th>
        <th style='text-align: center; font-weight: bolder;'>Arquivo</th>
        <th style='text-align: center; font-weight: bolder;'>Livro</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $exemplar):
                echo "<tr>
        <td style='text-align: center'>$exemplar->idExemplar</td>
        <td style='text-align: center'>$exemplar->Exemplares</td>";
            if ($exemplar->AcervoDigitalSN == 0)
                echo"<td style='text-align: center'>Fisico</td>";
            if ($exemplar->AcervoDigitalSN == 1)
                echo"<td style='text-align: center'>Digital</td>";
                echo"<td style='text-align: center'>$exemplar->UploadArquivo</td>";
        echo"<td style='text-align: center'>$exemplar->Titulo</td>
        <td style='text-align: center'><a href='?act=upd&id=$exemplar->idExemplar' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$exemplar->idExemplar' title='Remover'><i class='ti-close'></i></a></td>
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
?>

