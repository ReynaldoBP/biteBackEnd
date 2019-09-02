<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoSucursal
 *
 * @ORM\Table(name="INFO_SUCURSAL")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoSucursalRepository")
 */
class InfoSucursal
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_SUCURSAL", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var InfoRestaurante
    *
    * @ORM\ManyToOne(targetEntity="InfoRestaurante")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="RESTAURANTE_ID", referencedColumnName="ID_RESTAURANTE")
    * })
    */
    private $RESTAURANTEID;

    /**
     * @var string
     *
     * @ORM\Column(name="ES_MATRIZ", type="string", length=50)
     */
    private $ESMATRIZ;

    /**
     * @var string
     *
     * @ORM\Column(name="EN_CENTRO_COMERCIAL", type="string", length=50)
     */
    private $EN_CENTRO_COMERCIAL;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPCION", type="string", length=255)
     */
    private $DESCRIPCION;

    /**
     * @var string
     *
     * @ORM\Column(name="DIRECCION", type="string", length=255)
     */
    private $DIRECCION;

    /**
     * @var string
     *
     * @ORM\Column(name="NUMERO_CONTACTO", type="string", length=255)
     */
    private $NUMEROCONTACTO;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO_FACTURACION", type="string", length=255)
     */
    private $ESTADOFACTURACION;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO", type="string", length=255)
     */
    private $ESTADO;

    /**
     * @var float
     *
     * @ORM\Column(name="LATITUD", type="float", nullable=true)
     */
    private $LATITUD;

    /**
     * @var float
     *
     * @ORM\Column(name="LONGITUD", type="float", nullable=true)
     */
    private $LONGITUD;

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
     * Set ESMATRIZ
     *
     * @param string $ESMATRIZ
     *
     * @return InfoSucursal
     */
    public function setESMATRIZ($ESMATRIZ)
    {
        $this->ESMATRIZ = $ESMATRIZ;

        return $this;
    }

    /**
     * Get ESMATRIZ
     *
     * @return string
     */
    public function getESMATRIZ()
    {
        return $this->ESMATRIZ;
    }

    /**
     * Set DESCRIPCION
     *
     * @param string $DESCRIPCION
     *
     * @return InfoSucursal
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
     * Set DIRECCION
     *
     * @param string $DIRECCION
     *
     * @return InfoSucursal
     */
    public function setDIRECCION($DIRECCION)
    {
        $this->DIRECCION = $DIRECCION;

        return $this;
    }

    /**
     * Get DIRECCION
     *
     * @return string
     */
    public function getDIRECCION()
    {
        return $this->DIRECCION;
    }

    /**
     * Set NUMEROCONTACTO
     *
     * @param string $NUMEROCONTACTO
     *
     * @return InfoSucursal
     */
    public function setNUMEROCONTACTO($NUMEROCONTACTO)
    {
        $this->NUMEROCONTACTO = $NUMEROCONTACTO;

        return $this;
    }

    /**
     * Get NUMEROCONTACTO
     *
     * @return string
     */
    public function getNUMEROCONTACTO()
    {
        return $this->NUMEROCONTACTO;
    }

    /**
     * Set ESTADOFACTURACION
     *
     * @param string $ESTADOFACTURACION
     *
     * @return InfoSucursal
     */
    public function setESTADOFACTURACION($ESTADOFACTURACION)
    {
        $this->ESTADOFACTURACION = $ESTADOFACTURACION;

        return $this;
    }

    /**
     * Get ESTADOFACTURACION
     *
     * @return string
     */
    public function getESTADOFACTURACION()
    {
        return $this->ESTADOFACTURACION;
    }

    /**
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return InfoSucursal
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
     * Set LATITUD
     *
     * @param float $LATITUD
     *
     * @return InfoSucursal
     */
    public function setLATITUD($LATITUD)
    {
        $this->LATITUD = $LATITUD;

        return $this;
    }

    /**
     * Get LATITUD
     *
     * @return float
     */
    public function getLATITUD()
    {
        return $this->LATITUD;
    }

    /**
     * Set LONGITUD
     *
     * @param float $LONGITUD
     *
     * @return InfoSucursal
     */
    public function setLONGITUD($LONGITUD)
    {
        $this->LONGITUD = $LONGITUD;

        return $this;
    }

    /**
     * Get LONGITUD
     *
     * @return float
     */
    public function getLONGITUD()
    {
        return $this->LONGITUD;
    }

    /**
     * Set PAIS
     *
     * @param string $PAIS
     *
     * @return InfoSucursal
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
     * Set CIUDAD
     *
     * @param string $CIUDAD
     *
     * @return InfoSucursal
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
     * Set USRCREACION
     *
     * @param string $USRCREACION
     *
     * @return InfoSucursal
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
     * @return InfoSucursal
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
     * @return InfoSucursal
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
     * @return InfoSucursal
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

    /**
     * Set RESTAURANTEID
     *
     * @param \AppBundle\Entity\InfoRestaurante $RESTAURANTEID
     *
     * @return InfoSucursal
     */
    public function setRESTAURANTEID(\AppBundle\Entity\InfoRestaurante $RESTAURANTEID = null)
    {
        $this->RESTAURANTEID = $RESTAURANTEID;

        return $this;
    }

    /**
     * Get RESTAURANTEID
     *
     * @return \AppBundle\Entity\InfoRestaurante
     */
    public function getRESTAURANTEID()
    {
        return $this->RESTAURANTEID;
    }

    /**
     * Set PROVINCIA
     *
     * @param string $PROVINCIA
     *
     * @return InfoSucursal
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
     * Set PARROQUIA
     *
     * @param string $PARROQUIA
     *
     * @return InfoSucursal
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
     * Set ENCENTROCOMERCIAL
     *
     * @param string $ENCENTROCOMERCIAL
     *
     * @return InfoSucursal
     */
    public function setENCENTROCOMERCIAL($ENCENTROCOMERCIAL)
    {
        $this->EN_CENTRO_COMERCIAL = $ENCENTROCOMERCIAL;

        return $this;
    }

    /**
     * Get ENCENTROCOMERCIAL
     *
     * @return string
     */
    public function getENCENTROCOMERCIAL()
    {
        return $this->EN_CENTRO_COMERCIAL;
    }
}
