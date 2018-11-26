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
    private $UploadArquivo;
    private $AcervoDigitalSN;
    private $ExemplarQtde;
    private $fk_idLivro;

    /**
     * exemplar constructor.
     * @param $idExemplar
     * @param $UploadArquivo
     * @param $AcervoDigitalSN
     * @param $ExemplarcQtde
     * @param $fk_idLivro
     */
    public function __construct($idExemplar, $UploadArquivo, $AcervoDigitalSN, $ExemplarQtde, $fk_idLivro)
    {
        $this->idExemplar = $idExemplar;
        $this->UploadArquivo = $UploadArquivo;
        $this->AcervoDigitalSN = $AcervoDigitalSN;
        $this->ExemplarcQtde = $ExemplarQtde;
        $this->fk_idLivro = $fk_idLivro;
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
    public function getUploadArquivo()
    {
        return $this->UploadArquivo;
    }

    /**
     * @param mixed $UploadArquivo
     */
    public function setUploadArquivo($UploadArquivo)
    {
        $this->UploadArquivo = $UploadArquivo;
    }

    /**
     * @return mixed
     */
    public function getAcervoDigitalSN()
    {
        return $this->AcervoDigitalSN;
    }

    /**
     * @param mixed $AcervoDigitalSN
     */
    public function setAcervoDigitalSN($AcervoDigitalSN)
    {
        $this->AcervoDigitalSN = $AcervoDigitalSN;
    }

    /**
     * @return mixed
     */
    public function getExemplarcQtde()
    {
        return $this->ExemplarcQtde;
    }

    /**
     * @param mixed $ExemplarcQtde
     */
    public function setExemplarQtde($ExemplarQtde)
    {
        $this->ExemplarcQtde = $ExemplarQtde;
    }

    /**
     * @return mixed
     */
    public function getFkIdLivro()
    {
        return $this->fk_idLivro;
    }

    /**
     * @param mixed $fk_idLivro
     */
    public function setFkIdLivro($fk_idLivro)
    {
        $this->fk_idLivro = $fk_idLivro;
    }


}