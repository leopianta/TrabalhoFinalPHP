<?php

require_once 'db/connection.php';
require_once 'classes/livro.php';


class livroDAO
{
    public function remover($livro){
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM livro WHERE idLivro = :id");
            $statement->bindValue(":id", $livro->getIdLivro());
            if ($statement->execute()) {
                return "<script> alert('Registo foi excluído com êxito !'); </script>";
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function salvar($livro){
        global $pdo;
        try {
            if ($livro->getIdLivro() != "") {
                $statement = $pdo->prepare("UPDATE livro SET titulo=:titulo, ISBN=:ISBN, autores=:autores, edicao=:edicao, editora=:editora, ano=:ano, fk_idCategoria=:fk_idCategoria WHERE idLivro = :id;");
                $statement->bindValue(":id", $livro->getIdLivro());
            } else {
                $statement = $pdo->prepare("INSERT INTO livro (titulo, ISBN, autores, edicao, editora, ano, fk_idCategoria) VALUES (:titulo, :ISBN, :autores, :edicao, :editora, :ano, :fk_idCategoria);");
            }
            $statement->bindValue(":titulo",$livro->getTitulo());
            $statement->bindValue(":ISBN",$livro->getISBN());
            $statement->bindValue(":autores",$livro->getAutores());
            $statement->bindValue(":edicao",$livro->getEdicao());
            $statement->bindValue(":editora",$livro->getEditora());
            $statement->bindValue(":ano",$livro->getAno());
            $statement->bindValue(":fk_idCategoria",$livro->getFkIdCategoria());

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

    public function atualizar($livro){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT idLivro, titulo, ISBN, autores, edicao, editora, ano, fk_idCategoria FROM livro WHERE idLivro = :id");
            $statement->bindValue(":id", $livro->getIdLivro());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $livro->setIdLivro($rs->idLivro);
                $livro->setTitulo($rs->titulo);
                $livro->setISBN($rs->ISBN);
                $livro->setAutores($rs->autores);
                $livro->setEdicao($rs->edicao);
                $livro->setEditora($rs->editora);
                $livro->setAno($rs->ano);
                $livro->setFkIdCategoria($rs->fk_idCategoria);

                return $livro;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    //metodo que lista os livros com a categoria e quantidade de exemplares
    //somente os livros que possuem exemplares
    public function listaLivros()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT titulo, ISBN, autores, edicao, editora, ano, c.nome as Categoria , e.quant as Quantidade, 
                                                  e.digital_fisico, e.emprestimo_consulta
                                                  FROM livro l, exemplar e, categoria c
                                                  where e.fk_idLivro = l.idLivro and l.fk_idCategoria = c.idCategoria');
            if ($statement->execute()) {
                $listaLivros = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listaLivros;
            }else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
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


        $sql = "SELECT f.idLivro, f.titulo, f.ISBN, f.autores, f.edicao, f.editora, f.ano, c.nome as Categoria
        FROM livro f, categoria c
        WHERE f.fk_idCategoria = c.idCategoria LIMIT {$linha_inicial}, " . QTDE_REGISTROS;



        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM livro";
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
        <th style='text-align: center; font-weight: bolder;'>Titulo</th>
        <th style='text-align: center; font-weight: bolder;'>ISBN</th>
        <th style='text-align: center; font-weight: bolder;'>Autores</th>
        <th style='text-align: center; font-weight: bolder;'>Edição</th>
        <th style='text-align: center; font-weight: bolder;'>Ano</th>
        <th style='text-align: center; font-weight: bolder;'>Categoria</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $livro):


                echo "<tr>
        <td style='text-align: center'>$livro->idLivro</td>
        <td style='text-align: center'>$livro->titulo</td>
        <td style='text-align: center'>$livro->ISBN</td>
        <td style='text-align: center'>$livro->autores</td>
        <td style='text-align: center'>$livro->edicao</td>
         <td style='text-align: center'>$livro->ano</td>
         <td style='text-align: center'>$livro->Categoria</td>
        <td style='text-align: center'><a href='?act=upd&id=$livro->idLivro' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$livro->idLivro' title='Remover'><i class='ti-close'></i></a></td>
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