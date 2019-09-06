<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoCliente
 *
 * @ORM\Table(name="INFO_CLIENTE")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoClienteRepository")
 */
class InfoCliente
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CLIENTE", type="integer")
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
     * @var string
     *
     * @ORM\Column(name="CONTRASENIA", type="string", length=50, nullable=true)
     */
    private $CONTRASENIA;

    /**
     * @var string
     *
     * @ORM\Column(name="AUTENTICACION_RS", type="string", length=1, nullable=true)
     */
    private $AUTENTICACION_RS;

    /**
    * @var AdmiTipoClientePuntaje
    *
    * @ORM\ManyToOne(targetEntity="AdmiTipoClientePuntaje")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="TIPO_CLIENTE_PUNTAJE_ID", referencedColumnName="ID_TIPO_CLIENTE_PUNTAJE")
    * })
    */
    private $TIPOCLIENTEPUNTAJEID;

    /**
     * @var string
     *
     * @ORM\Column(name="IDENTIFICACION", type="string", length=100, nullable=true)
     */
    private $IDENTIFICACION;

    /**
     * @var string
     *
     * @ORM\Column(name="NOMBRE", type="string", length=100)
     */
    private $NOMBRE;

    /**
     * @var string
     *
     * @ORM\Column(name="APELLIDO", type="string", length=100)
     */
    private $APELLIDO;

    /**
     * @var string
     *
     * @ORM\Column(name="CORREO", type="string", length=100)
     */
    private $CORREO;

    /**
     * @var string
     *
     * @ORM\Column(name="DIRECCION", type="string", length=255, nullable=true)
     */
    private $DIRECCION;

    /**
     * @var string
     *
     * @ORM\Column(name="EDAD", type="string", length=255, nullable=true)
     */
    private $EDAD;

    /**
     * @var string
     *
     * @ORM\Column(name="TIPO_COMIDA", type="string", length=255, nullable=true)
     */
    private $TIPOCOMIDA;

    /**
     * @var string
     *
     * @ORM\Column(name="GENERO", type="string", length=255, nullable=true)
     */
    private $GENERO;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO", type="string", length=255)
     */
    private $ESTADO;

    /**
     * @var string
     *
     * @ORM\Column(name="SECTOR", type="string", length=255, nullable=true)
     */
    private $SECTOR;

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
     * Set IDENTIFICACION
     *
     * @param string $IDENTIFICACION
     *
     * @return InfoCliente
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
     * Set NOMBRE
     *
     * @param string $NOMBRE
     *
     * @return InfoCliente
     */
    public function setNOMBRE($NOMBRE)
    {
        $this->NOMBRE = $NOMBRE;

        return $this;
    }

    /**
     * Get NOMBRE
     *
     * @return string
     */
    public function getNOMBRE()
    {
        return $this->NOMBRE;
    }

    /**
     * Set APELLIDO
     *
     * @param string $APELLIDO
     *
     * @return InfoCliente
     */
    public function setAPELLIDO($APELLIDO)
    {
        $this->APELLIDO = $APELLIDO;

        return $this;
    }

    /**
     * Get APELLIDO
     *
     * @return string
     */
    public function getAPELLIDO()
    {
        return $this->APELLIDO;
    }

    /**
     * Set CORREO
     *
     * @param string $CORREO
     *
     * @return InfoCliente
     */
    public function setCORREO($CORREO)
    {
        $this->CORREO = $CORREO;

        return $this;
    }

    /**
     * Get CORREO
     *
     * @return string
     */
    public function getCORREO()
    {
        return $this->CORREO;
    }

    /**
     * Set DIRECCION
     *
     * @param string $DIRECCION
     *
     * @return InfoCliente
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
     * Set EDAD
     *
     * @param string $EDAD
     *
     * @return InfoCliente
     */
    public function setEDAD($EDAD)
    {
        $this->EDAD = $EDAD;

        return $this;
    }

    /**
     * Get EDAD
     *
     * @return string
     */
    public function getEDAD()
    {
        return $this->EDAD;
    }

    /**
     * Set TIPOCOMIDA
     *
     * @param string $TIPOCOMIDA
     *
     * @return InfoCliente
     */
    public function setTIPOCOMIDA($TIPOCOMIDA)
    {
        $this->TIPOCOMIDA = $TIPOCOMIDA;

        return $this;
    }

    /**
     * Get TIPOCOMIDA
     *
     * @return string
     */
    public function getTIPOCOMIDA()
    {
        return $this->TIPOCOMIDA;
    }

    /**
     * Set GENERO
     *
     * @param string $GENERO
     *
     * @return InfoCliente
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
     * @return InfoCliente
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
     * Set SECTOR
     *
     * @param string $SECTOR
     *
     * @return InfoCliente
     */
    public function setSECTOR($SECTOR)
    {
        $this->SECTOR = $SECTOR;

        return $this;
    }

    /**
     * Get SECTOR
     *
     * @return string
     */
    public function getSECTOR()
    {
        return $this->SECTOR;
    }

    /**
     * Set USRCREACION
     *
     * @param string $USRCREACION
     *
     * @return InfoCliente
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
     * @return InfoCliente
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
     * @return InfoCliente
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
     * @return InfoCliente
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
     * @return InfoCliente
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
     * Set TIPOCLIENTEPUNTAJEID
     *
     * @param \AppBundle\Entity\AdmiTipoClientePuntaje $TIPOCLIENTEPUNTAJEID
     *
     * @return InfoCliente
     */
    public function setTIPOCLIENTEPUNTAJEID(\AppBundle\Entity\AdmiTipoClientePuntaje $TIPOCLIENTEPUNTAJEID = null)
    {
        $this->TIPOCLIENTEPUNTAJEID = $TIPOCLIENTEPUNTAJEID;

        return $this;
    }

    /**
     * Get TIPOCLIENTEPUNTAJEID
     *
     * @return \AppBundle\Entity\AdmiTipoClientePuntaje
     */
    public function getTIPOCLIENTEPUNTAJEID()
    {
        return $this->TIPOCLIENTEPUNTAJEID;
    }

    /**
     * Set CONTRASENIA
     *
     * @param string $CONTRASENIA
     *
     * @return InfoCliente
     */
    public function setCONTRASENIA($CONTRASENIA)
    {
        $this->CONTRASENIA = $CONTRASENIA;

        return $this;
    }

    /**
     * Get CONTRASENIA
     *
     * @return string
     */
    public function getCONTRASENIA()
    {
        return $this->CONTRASENIA;
    }

    /**
     * Set AUTENTICACIONRS
     *
     * @param string $AUTENTICACIONRS
     *
     * @return InfoCliente
     */
    public function setAUTENTICACIONRS($AUTENTICACIONRS)
    {
        $this->AUTENTICACION_RS = $AUTENTICACIONRS;

        return $this;
    }

    /**
     * Get AUTENTICACIONRS
     *
     * @return string
     */
    public function getAUTENTICACIONRS()
    {
        return $this->AUTENTICACION_RS;
    }
}
