<?php
/**
 * Created by PhpStorm.
 * User: TiDaniel
 * Date: 21/10/2018
 * Time: 13:02
 */

class categoria
{
    private $idCategoria;
    private $nome;
    private $descricao;
	private $assunto;


    public function __construct($idCategoria, $nome, $descricao, $assunto)
    {
        $this->idCategoria = $idCategoria;
        $this->nome = $nome;
        $this->descricao = $descricao;
		$this->assunto = $assunto;
    }


    public function getIdCategoria()
    {
        return $this->idCategoria;
    }


    public function setIdCategoria($idCategoria): void
    {
        $this->idCategoria = $idCategoria;
    }


    public function getNome()
    {
        return $this->nome;
    }


    public function setNome($nome): void
    {
        $this->nome = $nome;
    }


    public function getDescricao()
    {
        return $this->descricao;
    }


    public function setDescricao($descricao): void
    {
        $this->descricao = $descricao;
    }

	
	public function getAssunto()
    {
        return $this->assunto;
    }


    public function setAssunto($assunto): void
    {
        $this->assunto = $assunto;
    }

}