<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmiParametro
 *
 * @ORM\Table(name="ADMI_PARAMETRO")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdmiParametroRepository")
 */
class AdmiParametro
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PARAMETRO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPCION", type="string", length=255)
     */
    private $DESCRIPCION;

    /**
     * @var string
     *
     * @ORM\Column(name="VALOR1", type="string", length=255)
     */
    private $VALOR1;

    /**
     * @var string
     *
     * @ORM\Column(name="VALOR2", type="string", length=255, nullable=true)
     */
    private $VALOR2;

    /**
     * @var string
     *
     * @ORM\Column(name="VALOR3", type="string", length=255, nullable=true)
     */
    private $VALOR3;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO", type="string", length=100)
     */
    private $ESTADO;

    /**
     * @var string
     *
     * @ORM\Column(name="USR_CREACION", type="string", length=255)
     */
    private $USRCREACION;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FE_CREACION", type="date")
     */
    private $FECREACION;

    /**
     * @var string
     *
     * @ORM\Column(name="USR_MODIFICACION", type="string", length=255, nullable=true)
     */
    private $USRMODIFICACION;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FE_MODIFICACION", type="date", nullable=true)
     */
    private $FEMODIFICACION;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set DESCRIPCION
     *
     * @param string $DESCRIPCION
     *
     * @return AdmiParametro
     */
    public function setDESCRIPCION($DESCRIPCION)
    {
        $this->DESCRIPCION = $DESCRIPCION;

        return $this;
    }

    /**
     * Get DESCRIPCION
     *
     * @return string
     */
    public function getDESCRIPCION()
    {
        return $this->DESCRIPCION;
    }

    /**
     * Set VALOR1
     *
     * @param string $VALOR1
     *
     * @return AdmiParametro
     */
    public function setVALOR1($VALOR1)
    {
        $this->VALOR1 = $VALOR1;

        return $this;
    }

    /**
     * Get VALOR1
     *
     * @return string
     */
    public function getVALOR1()
    {
        return $this->VALOR1;
    }

    /**
     * Set VALOR2
     *
     * @param string $VALOR2
     *
     * @return AdmiParametro
     */
    public function setVALOR2($VALOR2)
    {
        $this->VALOR2 = $VALOR2;

        return $this;
    }

    /**
     * Get VALOR2
     *
     * @return string
     */
    public function getVALOR2()
    {
        return $this->VALOR2;
    }

    /**
     * Set VALOR3
     *
     * @param string $VALOR3
     *
     * @return AdmiParametro
     */
    public function setVALOR3($VALOR3)
    {
        $this->VALOR3 = $VALOR3;

        return $this;
    }

    /**
     * Get VALOR3
     *
     * @return string
     */
    public function getVALOR3()
    {
        return $this->VALOR3;
    }

    /**
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return AdmiParametro
     */
    public function setESTADO($ESTADO)
    {
        $this->ESTADO = $ESTADO;

        return $this;
    }

    /**
     * Get ESTADO
     *
     * @return string
     */
    public function getESTADO()
    {
        return $this->ESTADO;
    }

    /**
     * Set USRCREACION
     *
     * @param string $USRCREACION
     *
     * @return AdmiParametro
     */
    public function setUSRCREACION($USRCREACION)
    {
        $this->USRCREACION = $USRCREACION;

        return $this;
    }

    /**
     * Get USRCREACION
     *
     * @return string
     */
    public function getUSRCREACION()
    {
        return $this->USRCREACION;
    }

    /**
     * Set FECREACION
     *
     * @param \DateTime $FECREACION
     *
     * @return AdmiParametro
     */
    public function setFECREACION($FECREACION)
    {
        $this->FECREACION = $FECREACION;

        return $this;
    }

    /**
     * Get FECREACION
     *
     * @return \DateTime
     */
    public function getFECREACION()
    {
        return $this->FECREACION;
    }

    /**
     * Set USRMODIFICACION
     *
     * @param string $USRMODIFICACION
     *
     * @return AdmiParametro
     */
    public function setUSRMODIFICACION($USRMODIFICACION)
    {
        $this->USRMODIFICACION = $USRMODIFICACION;

        return $this;
    }

    /**
     * Get USRMODIFICACION
     *
     * @return string
     */
    public function getUSRMODIFICACION()
    {
        return $this->USRMODIFICACION;
    }

    /**
     * Set FEMODIFICACION
     *
     * @param \DateTime $FEMODIFICACION
     *
     * @return AdmiParametro
     */
    public function setFEMODIFICACION($FEMODIFICACION)
    {
        $this->FEMODIFICACION = $FEMODIFICACION;

        return $this;
    }

    /**
     * Get FEMODIFICACION
     *
     * @return \DateTime
     */
    public function getFEMODIFICACION()
    {
        return $this->FEMODIFICACION;
    }
}
