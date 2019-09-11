<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoUsuario
 *
 * @ORM\Table(name="INFO_USUARIO")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoUsuarioRepository")
 */
class InfoUsuario
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_USUARIO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var AdmiTipoRol
    *
    * @ORM\ManyToOne(targetEntity="AdmiTipoRol")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="TIPO_ROL_ID", referencedColumnName="ID_TIPO_ROL")
    * })
    */
    private $TIPOROLID;

    /**
     * @var string
     *
     * @ORM\Column(name="IDENTIFICACION", type="string", length=50)
     */
    private $IDENTIFICACION;

    /**
     * @var string
     *
     * @ORM\Column(name="NOMBRES", type="string", length=255)
     */
    private $NOMBRES;

    /**
     * @var string
     *
     * @ORM\Column(name="APELLIDOS", type="string", length=255)
     */
    private $APELLIDOS;

    /**
     * @var string
     *
     * @ORM\Column(name="CONTRASENIA", type="string", length=255)
     */
    private $CONTRASENIA;

    /**
     * @var string
     *
     * @ORM\Column(name="IMAGEN", type="string", length=400)
     */
    private $IMAGEN;

    /**
     * @var string
     *
     * @ORM\Column(name="CORREO", type="string", length=100)
     */
    private $CORREO;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO", type="string", length=100)
     */
    private $ESTADO;

    /**
     * @var string
     *
     * @ORM\Column(name="PAIS", type="string", length=100, nullable=true)
     */
    private $PAIS;

    /**
     * @var string
     *
     * @ORM\Column(name="CIUDAD", type="string", length=100, nullable=true)
     */
    private $CIUDAD;

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
     * @return InfoUsuario
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
     * Set NOMBRES
     *
     * @param string $NOMBRES
     *
     * @return InfoUsuario
     */
    public function setNOMBRES($NOMBRES)
    {
        $this->NOMBRES = $NOMBRES;

        return $this;
    }

    /**
     * Get NOMBRES
     *
     * @return string
     */
    public function getNOMBRES()
    {
        return $this->NOMBRES;
    }

    /**
     * Set APELLIDOS
     *
     * @param string $APELLIDOS
     *
     * @return InfoUsuario
     */
    public function setAPELLIDOS($APELLIDOS)
    {
        $this->APELLIDOS = $APELLIDOS;

        return $this;
    }

    /**
     * Get APELLIDOS
     *
     * @return string
     */
    public function getAPELLIDOS()
    {
        return $this->APELLIDOS;
    }

    /**
     * Set CONTRASENIA
     *
     * @param string $CONTRASENIA
     *
     * @return InfoUsuario
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
     * Set IMAGEN
     *
     * @param string $IMAGEN
     *
     * @return InfoUsuario
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
     * Set CORREO
     *
     * @param string $CORREO
     *
     * @return InfoUsuario
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
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return InfoUsuario
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
     * Set PAIS
     *
     * @param string $PAIS
     *
     * @return InfoUsuario
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
     * @return InfoUsuario
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
     * @return InfoUsuario
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
     * @return InfoUsuario
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
     * @return InfoUsuario
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
     * @return InfoUsuario
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
     * Set TIPOROLID
     *
     * @param \AppBundle\Entity\AdmiTipoRol $TIPOROLID
     *
     * @return InfoUsuario
     */
    public function setTIPOROLID(\AppBundle\Entity\AdmiTipoRol $TIPOROLID = null)
    {
        $this->TIPOROLID = $TIPOROLID;

        return $this;
    }

    /**
     * Get TIPOROLID
     *
     * @return \AppBundle\Entity\AdmiTipoRol
     */
    public function getTIPOROLID()
    {
        return $this->TIPOROLID;
    }


}
