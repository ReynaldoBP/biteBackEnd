<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoRestaurante
 *
 * @ORM\Table(name="INFO_RESTAURANTE")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoRestauranteRepository")
 */
class InfoRestaurante
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_RESTAURANTE", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var InfoUsuario
    *
    * @ORM\ManyToOne(targetEntity="InfoUsuario")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="USUARIO_ID", referencedColumnName="ID_USUARIO")
    * })
    */
    private $USUARIOID;

    /**
    * @var AdmiTipoComida
    *
    * @ORM\ManyToOne(targetEntity="AdmiTipoComida")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="TIPO_COMIDA_ID", referencedColumnName="ID_TIPO_COMIDA")
    * })
    */
    private $TIPOCOMIDAID;

    /**
     * @var string
     *
     * @ORM\Column(name="TIPO_IDENTIFICACION", type="string", length=255)
     */
    private $TIPOIDENTIFICACION;

    /**
     * @var string
     *
     * @ORM\Column(name="IDENTIFICACION", type="string", length=255)
     */
    private $IDENTIFICACION;

    /**
     * @var string
     *
     * @ORM\Column(name="RAZON_SOCIAL", type="string", length=255)
     */
    private $RAZONSOCIAL;

    /**
     * @var string
     *
     * @ORM\Column(name="NOMBRE_COMERCIAL", type="string", length=255)
     */
    private $NOMBRECOMERCIAL;

    /**
     * @var string
     *
     * @ORM\Column(name="REPRESENTANTE_LEGAL", type="string", length=255, nullable=true)
     */
    private $REPRESENTANTELEGAL;

    /**
     * @var string
     *
     * @ORM\Column(name="DIRECCION_TRIBUTARIO", type="string", length=255, nullable=true)
     */
    private $DIRECCIONTRIBUTARIO;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_CATALOGO", type="string", length=255, nullable=true)
     */
    private $URLCATALOGO;

    /**
     * @var string
     *
     * @ORM\Column(name="NUMERO_CONTACTO", type="string", length=100, nullable=true)
     */
    private $NUMEROCONTACTO;

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
     * Set TIPOIDENTIFICACION
     *
     * @param string $TIPOIDENTIFICACION
     *
     * @return InfoRestaurante
     */
    public function setTIPOIDENTIFICACION($TIPOIDENTIFICACION)
    {
        $this->TIPOIDENTIFICACION = $TIPOIDENTIFICACION;

        return $this;
    }

    /**
     * Get TIPOIDENTIFICACION
     *
     * @return string
     */
    public function getTIPOIDENTIFICACION()
    {
        return $this->TIPOIDENTIFICACION;
    }

    /**
     * Set IDENTIFICACION
     *
     * @param string $IDENTIFICACION
     *
     * @return InfoRestaurante
     */
    public function setIDENTIFICACION($IDENTIFICACION)
    {
        $this->IDENTIFICACION = $IDENTIFICACION;

        return $this;
    }

    /**
     * Get IDENTIFICACION
     *
     * @return string
     */
    public function getIDENTIFICACION()
    {
        return $this->IDENTIFICACION;
    }

    /**
     * Set RAZONSOCIAL
     *
     * @param string $RAZONSOCIAL
     *
     * @return InfoRestaurante
     */
    public function setRAZONSOCIAL($RAZONSOCIAL)
    {
        $this->RAZONSOCIAL = $RAZONSOCIAL;

        return $this;
    }

    /**
     * Get RAZONSOCIAL
     *
     * @return string
     */
    public function getRAZONSOCIAL()
    {
        return $this->RAZONSOCIAL;
    }

    /**
     * Set NOMBRECOMERCIAL
     *
     * @param string $NOMBRECOMERCIAL
     *
     * @return InfoRestaurante
     */
    public function setNOMBRECOMERCIAL($NOMBRECOMERCIAL)
    {
        $this->NOMBRECOMERCIAL = $NOMBRECOMERCIAL;

        return $this;
    }

    /**
     * Get NOMBRECOMERCIAL
     *
     * @return string
     */
    public function getNOMBRECOMERCIAL()
    {
        return $this->NOMBRECOMERCIAL;
    }

    /**
     * Set REPRESENTANTELEGAL
     *
     * @param string $REPRESENTANTELEGAL
     *
     * @return InfoRestaurante
     */
    public function setREPRESENTANTELEGAL($REPRESENTANTELEGAL)
    {
        $this->REPRESENTANTELEGAL = $REPRESENTANTELEGAL;

        return $this;
    }

    /**
     * Get REPRESENTANTELEGAL
     *
     * @return string
     */
    public function getREPRESENTANTELEGAL()
    {
        return $this->REPRESENTANTELEGAL;
    }

    /**
     * Set DIRECCIONTRIBUTARIO
     *
     * @param string $DIRECCIONTRIBUTARIO
     *
     * @return InfoRestaurante
     */
    public function setDIRECCIONTRIBUTARIO($DIRECCIONTRIBUTARIO)
    {
        $this->DIRECCIONTRIBUTARIO = $DIRECCIONTRIBUTARIO;

        return $this;
    }

    /**
     * Get DIRECCIONTRIBUTARIO
     *
     * @return string
     */
    public function getDIRECCIONTRIBUTARIO()
    {
        return $this->DIRECCIONTRIBUTARIO;
    }

    /**
     * Set URLCATALOGO
     *
     * @param string $URLCATALOGO
     *
     * @return InfoRestaurante
     */
    public function setURLCATALOGO($URLCATALOGO)
    {
        $this->URLCATALOGO = $URLCATALOGO;

        return $this;
    }

    /**
     * Get URLCATALOGO
     *
     * @return string
     */
    public function getURLCATALOGO()
    {
        return $this->URLCATALOGO;
    }

    /**
     * Set NUMEROCONTACTO
     *
     * @param string $NUMEROCONTACTO
     *
     * @return InfoRestaurante
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
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return InfoRestaurante
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
     * @return InfoRestaurante
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
     * @return InfoRestaurante
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
     * @return InfoRestaurante
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
     * @return InfoRestaurante
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
     * Set USUARIOID
     *
     * @param \AppBundle\Entity\InfoUsuario $USUARIOID
     *
     * @return InfoRestaurante
     */
    public function setUSUARIOID(\AppBundle\Entity\InfoUsuario $USUARIOID = null)
    {
        $this->USUARIOID = $USUARIOID;

        return $this;
    }

    /**
     * Get USUARIOID
     *
     * @return \AppBundle\Entity\InfoUsuario
     */
    public function getUSUARIOID()
    {
        return $this->USUARIOID;
    }

    /**
     * Set TIPOCOMIDAID
     *
     * @param \AppBundle\Entity\AdmiTipoComida $TIPOCOMIDAID
     *
     * @return InfoRestaurante
     */
    public function setTIPOCOMIDAID(\AppBundle\Entity\AdmiTipoComida $TIPOCOMIDAID = null)
    {
        $this->TIPOCOMIDAID = $TIPOCOMIDAID;

        return $this;
    }

    /**
     * Get TIPOCOMIDAID
     *
     * @return \AppBundle\Entity\AdmiTipoComida
     */
    public function getTIPOCOMIDAID()
    {
        return $this->TIPOCOMIDAID;
    }
}
