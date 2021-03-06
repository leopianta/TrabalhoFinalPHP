<?php
/**
 * Created by PhpStorm.
 * User: TiDaniel
 * Date: 21/10/2018
 * Time: 13:02
 */

class emprestimo
{
    private $idEmprestimo;
    private $idReserva;
    private $idUsuario;
    private $idExemplar;
    private $dataEmprestimo;

    /**
     * reserva constructor.
     * @param $idReserva
     * @param $idUsuario
     * @param $idExemplar
     * @param $dataEmprestimo
     */
    public function __construct($idEmprestimo, $idReserva, $idUsuario, $idExemplar, $dataEmprestimo)
    {
        $this->idEmprestimo = $idEmprestimo;
        $this->idReserva = $idReserva;
        $this->idUsuario = $idUsuario;
        $this->idExemplar = $idExemplar;
        $this->dataEmprestimo = $dataEmprestimo;
    }


    public function getIdEmprestimo()
    {
        return $this->idEmprestimo;
    }

    /**
     * @param mixed $idEmprestimo
     */
    public function setIdEmprestimo($idEmprestimo)
    {
        $this->idEmprestimo = $idEmprestimo;
    }


    /**
     * @return mixed
     */
    public function getIdReserva()
    {
        return $this->idReserva;
    }

    /**
     * @param mixed $idReserva
     */
    public function setIdReserva($idReserva)
    {
        $this->idReserva = $idReserva;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return mixed
     */
    public function getIdExemplar()
    {
        return $this->idExemplar;
    }

    /**
     * @param mixed $idExemplar
     */
    public function setIdExemplar($idExemplar)
    {
        $this->idExemplar = $idExemplar;
    }

    /**
     * @return mixed
     */
    public function getDataEmprestimo()
    {
        return $this->dataEmprestimo;
    }

    /**
     * @param mixed $dataEmprestimo
     */
    public function setDataEmprestimo($dataEmprestimo)
    {
        $this->dataEmprestimo = $dataEmprestimo;
    }


}