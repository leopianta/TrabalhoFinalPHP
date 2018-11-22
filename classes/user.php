<?php

class user
{

    private $idUsuario;
    private $Login;
    private $Senha;
    private $Nome;
    private $tipoUsuario;

    function __construct($idUsuario, $Login, $Senha, $Nome, $tipoUsuario) {
        $this->idUsuario = $idUsuario;
        $this->Login = $Login;
        $this->Senha = $Senha;
        $this->Nome = $Nome;
        $this->tipoUsuario = $tipoUsuario;
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
    public function setIdUsuario($idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->Login;
    }

    /**
     * @param mixed $Login
     */
    public function setLogin($Login): void
    {
        $this->Login = $Login;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->Senha;
    }

    /**
     * @param mixed $Senha
     */
    public function setSenha($Senha): void
    {
        $this->Senha = $Senha;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->Nome;
    }

    /**
     * @param mixed $Nome
     */
    public function setNome($Nome): void
    {
        $this->Nome = $Nome;
    }

    /**
     * @return mixed
     */
    public function getTipoUsuario()
    {
        return $this->tipoUsuario;
    }

    /**
     * @param mixed $tipoUsuario
     */
    public function setTipoUsuario($tipoUsuario): void
    {
        $this->tipoUsuario = $tipoUsuario;
    }

}