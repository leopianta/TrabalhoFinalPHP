<?php
/**
 * Created by PhpStorm.
 * User: TiDaniel
 * Date: 21/10/2018
 * Time: 13:02
 */

class reserva
{
    private $idReserva;
    private $idUsuario;
    private $idLivro;
    private $dataReserva;
    private $emprestimoSN;

    /**
     * reserva constructor.
     * @param $idReserva
     * @param $idUsuario
     * @param $idLivro
     * @param $dataReserva
     */
    public function __construct($idReserva, $idUsuario, $idLivro, $dataReserva, $emprestimoSN)
    {
        $this->idReserva = $idReserva;
        $this->idUsuario = $idUsuario;
        $this->idLivro = $idLivro;
        $this->dataReserva = $dataReserva;
        $this->emprestimoSN = $emprestimoSN;
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
    public function getIdLivro()
    {
        return $this->idLivro;
    }

    /**
     * @param mixed $idLivro
     */
    public function setIdLivro($idLivro)
    {
        $this->idLivro = $idLivro;
    }

    /**
     * @return mixed
     */
    public function getDataReserva()
    {
        return $this->dataReserva;
    }

    /**
     * @param mixed $dataReserva
     */
    public function setDataReserva($dataReserva)
    {
        $this->dataReserva = $dataReserva;
    }

    /**
     * @return mixed
     */
    public function getEmprestimoSN()
    {
        return $this->emprestimoSN;
    }

    /**
     * @param mixed $dataReserva
     */
    public function setEmprestimoSN($emprestimoSN)
    {
        $this->emprestimoSN = $emprestimoSN;
    }


}