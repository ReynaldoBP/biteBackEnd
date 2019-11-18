<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoPublicidad
 *
 * @ORM\Table(name="INFO_PUBLICIDAD")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoPublicidadRepository")
 */
class InfoPublicidad
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PUBLICIDAD", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPCION", type="string", length=255, nullable=true)
     */
    private $DESCRIPCION;

    /**
     * @var string
     *
     * @ORM\Column(name="IMAGEN", type="string", length=400)
     */
    private $IMAGEN;

    /**
     * @var string
     *
     * @ORM\Column(name="ORIENTACION", type="string", length=50)
     */
    private $ORIENTACION;

    /**
     * @var string
     *
     * @ORM\Column(name="EDAD_MAXIMA", type="integer", nullable=true)
     */
    private $EDADMAXIMA;

    /**
     * @var string
     *
     * @ORM\Column(name="EDAD_MINIMA", type="integer", nullable=true)
     */
    private $EDADMINIMA;

    /**
     * @var string
     *
     * @ORM\Column(name="GENERO", type="string", length=50, nullable=true)
     */
    private $GENERO;

    /**
     * @var string
     *
     * @ORM\Column(name="PAIS", type="string", length=100)
     */
    private $PAIS;

    /**
     * @var string
     *
     * @ORM\Column(name="PROVINCIA", type="string", length=100)
     */
    private $PROVINCIA;

    /**
     * @var string
     *
     * @ORM\Column(name="CIUDAD", type="string", length=100)
     */
    private $CIUDAD;

    /**
     * @var string
     *
     * @ORM\Column(name="PARROQUIA", type="string", length=100)
     */
    private $PARROQUIA;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO", type="string", length=100)
     */
    private $ESTADO;

    /**
     * @var int
     *
     * @ORM\Column(name="CANT_VISTAS",type="integer", nullable=true)
     */
    private $CANT_VISTAS;

    /**
     * @var string
     *
     * @ORM\Column(name="USR_CREACION", type="string", length=255)
     */
    private $USR_CREACION;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FE_CREACION", type="date")
     */
    private $FE_CREACION;

    /**
     * @var string
     *
     * @ORM\Column(name="USR_MODIFICACION", type="string", length=255, nullable=true)
     */
    private $USR_MODIFICACION;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FE_MODIFICACION", type="date", nullable=true)
     */
    private $FE_MODIFICACION;

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
     * @return InfoPublicidad
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
     * Set IMAGEN
     *
     * @param string $IMAGEN
     *
     * @return InfoPublicidad
     */
    public function setIMAGEN($IMAGEN)
    {
        $this->IMAGEN = $IMAGEN;

        return $this;
    }

    /**
     * Get IMAGEN
     *
     * @return string
     */
    public function getIMAGEN()
    {
        return $this->IMAGEN;
    }

    /**
     * Set EDADMAXIMA
     *
     * @param int $EDADMAXIMA
     *
     * @return InfoPublicidad
     */
    public function setEDADMAXIMA($EDADMAXIMA)
    {
        $this->EDADMAXIMA = $EDADMAXIMA;

        return $this;
    }

    /**
     * Get EDADMAXIMA
     *
     * @return int
     */
    public function getEDADMAXIMA()
    {
        return $this->EDADMAXIMA;
    }

    /**
     * Set EDADMINIMA
     *
     * @param int $EDADMINIMA
     *
     * @return InfoPublicidad
     */
    public function setEDADMINIMA($EDADMINIMA)
    {
        $this->EDADMINIMA = $EDADMINIMA;

        return $this;
    }

    /**
     * Get EDADMINIMA
     *
     * @return int
     */
    public function getEDADMINIMA()
    {
        return $this->EDADMINIMA;
    }

    /**
     * Set GENERO
     *
     * @param string $GENERO
     *
     * @return InfoPublicidad
     */
    public function setGENERO($GENERO)
    {
        $this->GENERO = $GENERO;

        return $this;
    }

    /**
     * Get GENERO
     *
     * @return string
     */
    public function getGENERO()
    {
        return $this->GENERO;
    }

    /**
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return InfoPublicidad
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
     * @return InfoPublicidad
     */
    public function setUSRCREACION($USRCREACION)
    {
        $this->USR_CREACION = $USRCREACION;

        return $this;
    }

    /**
     * Get USRCREACION
     *
     * @return string
     */
    public function getUSRCREACION()
    {
        return $this->USR_CREACION;
    }

    /**
     * Set FECREACION
     *
     * @param \DateTime $FECREACION
     *
     * @return InfoPublicidad
     */
    public function setFECREACION($FECREACION)
    {
        $this->FE_CREACION = $FECREACION;

        return $this;
    }

    /**
     * Get FECREACION
     *
     * @return \DateTime
     */
    public function getFECREACION()
    {
        return $this->FE_CREACION;
    }

    /**
     * Set USRMODIFICACION
     *
     * @param string $USRMODIFICACION
     *
     * @return InfoPublicidad
     */
    public function setUSRMODIFICACION($USRMODIFICACION)
    {
        $this->USR_MODIFICACION = $USRMODIFICACION;

        return $this;
    }

    /**
     * Get USRMODIFICACION
     *
     * @return string
     */
    public function getUSRMODIFICACION()
    {
        return $this->USR_MODIFICACION;
    }

    /**
     * Set FEMODIFICACION
     *
     * @param \DateTime $FEMODIFICACION
     *
     * @return InfoPublicidad
     */
    public function setFEMODIFICACION($FEMODIFICACION)
    {
        $this->FE_MODIFICACION = $FEMODIFICACION;

        return $this;
    }

    /**
     * Get FEMODIFICACION
     *
     * @return \DateTime
     */
    public function getFEMODIFICACION()
    {
        return $this->FE_MODIFICACION;
    }

    /**
     * Set PAIS
     *
     * @param string $PAIS
     *
     * @return InfoPublicidad
     */
    public function setPAIS($PAIS)
    {
        $this->PAIS = $PAIS;

        return $this;
    }

    /**
     * Get PAIS
     *
     * @return string
     */
    public function getPAIS()
    {
        return $this->PAIS;
    }

    /**
     * Set PROVINCIA
     *
     * @param string $PROVINCIA
     *
     * @return InfoPublicidad
     */
    public function setPROVINCIA($PROVINCIA)
    {
        $this->PROVINCIA = $PROVINCIA;

        return $this;
    }

    /**
     * Get PROVINCIA
     *
     * @return string
     */
    public function getPROVINCIA()
    {
        return $this->PROVINCIA;
    }

    /**
     * Set CIUDAD
     *
     * @param string $CIUDAD
     *
     * @return InfoPublicidad
     */
    public function setCIUDAD($CIUDAD)
    {
        $this->CIUDAD = $CIUDAD;

        return $this;
    }

    /**
     * Get CIUDAD
     *
     * @return string
     */
    public function getCIUDAD()
    {
        return $this->CIUDAD;
    }

    /**
     * Set PARROQUIA
     *
     * @param string $PARROQUIA
     *
     * @return InfoPublicidad
     */
    public function setPARROQUIA($PARROQUIA)
    {
        $this->PARROQUIA = $PARROQUIA;

        return $this;
    }

    /**
     * Get PARROQUIA
     *
     * @return string
     */
    public function getPARROQUIA()
    {
        return $this->PARROQUIA;
    }

    /**
     * Set ORIENTACION
     *
     * @param string $ORIENTACION
     *
     * @return InfoPublicidad
     */
    public function setORIENTACION($ORIENTACION)
    {
        $this->ORIENTACION = $ORIENTACION;

        return $this;
    }

    /**
     * Get ORIENTACION
     *
     * @return string
     */
    public function getORIENTACION()
    {
        return $this->ORIENTACION;
    }

    /**
     * Set CANTVISTAS
     *
     * @param integer $CANTVISTAS
     *
     * @return InfoPublicidad
     */
    public function setCANTVISTAS($CANTVISTAS)
    {
        $this->CANT_VISTAS = $CANTVISTAS;

        return $this;
    }

    /**
     * Get CANTVISTAS
     *
     * @return integer
     */
    public function getCANTVISTAS()
    {
        return $this->CANT_VISTAS;
    }
}
