<?php
/**
 * Created by PhpStorm.
 * User: TiDaniel
 * Date: 21/10/2018
 * Time: 13:07
 */

class exemplar
{
    private $idExemplar;
    private $quant;
    private $digital_fisico;
    private $arquivo;
    private $emprestimo_consulta;
    private $fk_idLivro;


    public function __construct($idExemplar, $quant, $digital_fisico, $arquivo, $emprestimo_consulta, $fk_idLivro)
    {
        $this->idExemplar = $idExemplar;
        $this->quant = $quant;
        $this->digital_fisico = $digital_fisico;
        $this->arquivo = $arquivo;
        $this->emprestimo_consulta = $emprestimo_consulta;
        $this->fk_idLivro = $fk_idLivro;
    }


    public function getIdExemplar()
    {
        return $this->idExemplar;
    }


    public function setIdExemplar($idExemplar): void
    {
        $this->idExemplar = $idExemplar;
    }


    public function getQuant()
    {
        return $this->quant;
    }


    public function setQuant($quant): void
    {
        $this->quant = $quant;
    }


    public function getDigitalFisico()
    {
        return $this->digital_fisico;
    }


    public function setDigitalFisico($digital_fisico): void
    {
        $this->digital_fisico = $digital_fisico;
    }


    public function getArquivo()
    {
        return $this->arquivo;
    }


    public function setArquivo($arquivo): void
    {
        $this->arquivo = $arquivo;
    }


    public function getEmprestimoConsulta()
    {
        return $this->emprestimo_consulta;
    }


    public function setEmprestimoConsulta($emprestimo_consulta): void
    {
        $this->emprestimo_consulta = $emprestimo_consulta;
    }


    public function getFkIdLivro()
    {
        return $this->fk_idLivro;
    }


    public function setFkIdLivro($fk_idLivro): void
    {
        $this->fk_idLivro = $fk_idLivro;
    }



}