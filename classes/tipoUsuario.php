<?php
/**
 * Created by PhpStorm.
 * User: TiDaniel
 * Date: 21/10/2018
 * Time: 13:02
 */

class tipoUsuario
{
    private $idAutor;
    private $nome;

    public function __construct($idAutor, $nome)
    {
        $this->idAutor = $idAutor;
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getIdAutor()
    {
        return $this->idAutor;
    }

    /**
     * @param mixed $idAutor
     */
    public function setIdAutor($idAutor): void
    {
        $this->idAutor = $idAutor;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome): void
    {
        $this->nome = $nome;
    }



}