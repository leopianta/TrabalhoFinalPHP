<?php
/**
 * Created by PhpStorm.
 * User: TiDaniel
 * Date: 21/10/2018
 * Time: 13:02
 */

class editora
{
    private $idEditora;
    private $nome;
    private $sigla;

    public function __construct($idEditora, $nome, $sigla)
    {
        $this->idEditora = $idEditora;
        $this->nome = $nome;
        $this->sigla = $sigla;
    }


    public function getIdEditora()
    {
        return $this->idEditora;
    }


    public function setIdEditora($idEditora): void
    {
        $this->idEditora = $idEditora;
    }


    public function getNome()
    {
        return $this->nome;
    }


    public function setNome($nome): void
    {
        $this->nome = $nome;
    }


    public function getSigla()
    {
        return $this->sigla;
    }


    public function setSigla($sigla): void
    {
        $this->sigla = $sigla;
    }

}