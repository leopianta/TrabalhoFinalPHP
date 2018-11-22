<?php
/**
 * Created by PhpStorm.
 * User: TiDaniel
 * Date: 21/10/2018
 * Time: 13:09
 */

class livro
{
    private $idLivro;
    private $titulo;
    private $ISBN;
    private $autores;
    private $edicao;
    private $editora;
    private $ano;
    private $fk_idCategoria;


    public function __construct($idLivro, $titulo, $ISBN, $autores, $edicao, $editora, $ano, $fk_idCategoria)
    {
        $this->idLivro = $idLivro;
        $this->titulo = $titulo;
        $this->ISBN = $ISBN;
        $this->autores = $autores;
        $this->edicao = $edicao;
        $this->editora = $editora;
        $this->ano = $ano;
        $this->fk_idCategoria = $fk_idCategoria;
    }


    public function getIdLivro()
    {
        return $this->idLivro;
    }


    public function setIdLivro($idLivro): void
    {
        $this->idLivro = $idLivro;
    }


    public function getTitulo()
    {
        return $this->titulo;
    }


    public function setTitulo($titulo): void
    {
        $this->titulo = $titulo;
    }


    public function getISBN()
    {
        return $this->ISBN;
    }


    public function setISBN($ISBN): void
    {
        $this->ISBN = $ISBN;
    }

    public function getAutores()
    {
        return $this->autores;
    }


    public function setAutores($autores): void
    {
        $this->autores = $autores;
    }


    public function getEdicao()
    {
        return $this->edicao;
    }



    public function setEdicao($edicao): void
    {
        $this->edicao = $edicao;
    }


    public function getEditora()
    {
        return $this->editora;
    }


    public function setEditora($editora): void
    {
        $this->editora = $editora;
    }


    public function getAno()
    {
        return $this->ano;
    }


    public function setAno($ano): void
    {
        $this->ano = $ano;
    }



    public function getFkIdCategoria()
    {
        return $this->fk_idCategoria;
    }


    public function setFkIdCategoria($fk_idCategoria): void
    {
        $this->fk_idCategoria = $fk_idCategoria;
    }


}