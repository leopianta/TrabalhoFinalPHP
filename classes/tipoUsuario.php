<?php
/**
 * Created by PhpStorm.
 * User: TiDaniel
 * Date: 21/10/2018
 * Time: 13:02
 */

class tipoUsuario
{
    private $idTipoUsuario;
    private $Descricao;

    /**
     * tipoUsuario constructor.
     * @param $idTipoUsuario
     * @param $Descricao
     */
    public function __construct($idTipoUsuario, $Descricao)
    {
        $this->idTipoUsuario = $idTipoUsuario;
        $this->Descricao = $Descricao;
    }

    /**
     * @return mixed
     */
    public function getIdTipoUsuario()
    {
        return $this->idTipoUsuario;
    }

    /**
     * @param mixed $idTipoUsuario
     */
    public function setIdTipoUsuario($idTipoUsuario)
    {
        $this->idTipoUsuario = $idTipoUsuario;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->Descricao;
    }

    /**
     * @param mixed $Descricao
     */
    public function setDescricao($Descricao)
    {
        $this->Descricao = $Descricao;
    }

}