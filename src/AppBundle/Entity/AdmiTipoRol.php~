<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmiTipoRol
 *
 * @ORM\Table(name="admi_tipo_rol")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdmiTipoRolRepository")
 */
class AdmiTipoRol
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_TIPO_ROL", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPCION_TIPO_ROL", type="string", length=255)
     */
    private $DESCRIPCION_TIPO_ROL;

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
     * @ORM\OneToMany(targetEntity="InfoUsuario", mappedBy="TIPOROLID")
     */
    private $usuario_id;

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
     * Set DESCRIPCION_TIPO_ROL
     *
     * @param string $DESCRIPCION_TIPO_ROL
     *
     * @return AdmiTipoRol
     */
    public function setDESCRIPCION_TIPO_ROL($DESCRIPCION_TIPO_ROL)
    {
        $this->DESCRIPCION_TIPO_ROL = $DESCRIPCION_TIPO_ROL;

        return $this;
    }

    /**
     * Get DESCRIPCION_TIPO_ROL
     *
     * @return string
     */
    public function getDESCRIPCION_TIPO_ROL()
    {
        return $this->DESCRIPCION_TIPO_ROL;
    }

    /**
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return AdmiTipoRol
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
     * Set USR_CREACION
     *
     * @param string $USR_CREACION
     *
     * @return AdmiTipoRol
     */
    public function setUSR_CREACION($USR_CREACION)
    {
        $this->USR_CREACION = $USR_CREACION;

        return $this;
    }

    /**
     * Get USR_CREACION
     *
     * @return string
     */
    public function getUSR_CREACION()
    {
        return $this->USR_CREACION;
    }

    /**
     * Set FE_CREACION
     *
     * @param \DateTime $FE_CREACION
     *
     * @return AdmiTipoRol
     */
    public function setFE_CREACION($FE_CREACION)
    {
        $this->FE_CREACION = $FE_CREACION;

        return $this;
    }

    /**
     * Get FE_CREACION
     *
     * @return \DateTime
     */
    public function getFE_CREACION()
    {
        return $this->FE_CREACION;
    }

    /**
     * Set USR_MODIFICACION
     *
     * @param string $USR_MODIFICACION
     *
     * @return AdmiTipoRol
     */
    public function setUSR_MODIFICACION($USR_MODIFICACION)
    {
        $this->USR_MODIFICACION = $USR_MODIFICACION;

        return $this;
    }

    /**
     * Get USR_MODIFICACION
     *
     * @return string
     */
    public function getUSR_MODIFICACION()
    {
        return $this->USR_MODIFICACION;
    }

    /**
     * Set FE_MODIFICACION
     *
     * @param \DateTime $FE_MODIFICACION
     *
     * @return AdmiTipoRol
     */
    public function setFE_MODIFICACION($FE_MODIFICACION)
    {
        $this->FE_MODIFICACION = $FE_MODIFICACION;

        return $this;
    }

    /**
     * Get FE_MODIFICACION
     *
     * @return \DateTime
     */
    public function getFE_MODIFICACION()
    {
        return $this->FE_MODIFICACION;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuario_id = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set DESCRIPCIONTIPOROL
     *
     * @param string $DESCRIPCIONTIPOROL
     *
     * @return AdmiTipoRol
     */
    public function setDESCRIPCIONTIPOROL($DESCRIPCIONTIPOROL)
    {
        $this->DESCRIPCION_TIPO_ROL = $DESCRIPCIONTIPOROL;

        return $this;
    }

    /**
     * Get DESCRIPCIONTIPOROL
     *
     * @return string
     */
    public function getDESCRIPCIONTIPOROL()
    {
        return $this->DESCRIPCION_TIPO_ROL;
    }

    /**
     * Set USRCREACION
     *
     * @param string $USRCREACION
     *
     * @return AdmiTipoRol
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
     * @return AdmiTipoRol
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
     * @return AdmiTipoRol
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
     * @return AdmiTipoRol
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
     * Add usuarioId
     *
     * @param \AppBundle\Entity\InfoUsuario $usuarioId
     *
     * @return AdmiTipoRol
     */
    public function addUsuarioId(\AppBundle\Entity\InfoUsuario $usuarioId)
    {
        $this->usuario_id[] = $usuarioId;

        return $this;
    }

    /**
     * Remove usuarioId
     *
     * @param \AppBundle\Entity\InfoUsuario $usuarioId
     */
    public function removeUsuarioId(\AppBundle\Entity\InfoUsuario $usuarioId)
    {
        $this->usuario_id->removeElement($usuarioId);
    }

    /**
     * Get usuarioId
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }
}
