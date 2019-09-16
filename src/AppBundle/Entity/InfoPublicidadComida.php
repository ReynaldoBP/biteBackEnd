<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoPublicidadComida
 *
 * @ORM\Table(name="INFO_PUBLICIDAD_COMIDA")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoPublicidadComidaRepository")
 */
class InfoPublicidadComida
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PUBLICIDAD_COMIDA", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var InfoPublicidad
    *
    * @ORM\ManyToOne(targetEntity="InfoPublicidad")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="PUBLICIDAD_ID", referencedColumnName="ID_PUBLICIDAD")
    * })
    */
    private $PUBLICIDADID;

    /**
    * @var AdmiTipoComida
    *
    * @ORM\ManyToOne(targetEntity="AdmiTipoComida")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="TIPO_COMIDA_ID", referencedColumnName="ID_TIPO_COMIDA")
    * })
    */
    private $TIPO_COMIDAID;

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
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return InfoPublicidadComida
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
     * @return InfoPublicidadComida
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
     * @return InfoPublicidadComida
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
     * @return InfoPublicidadComida
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
     * @return InfoPublicidadComida
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
     * Set PUBLICIDADID
     *
     * @param \AppBundle\Entity\InfoPublicidad $PUBLICIDADID
     *
     * @return InfoPublicidadComida
     */
    public function setPUBLICIDADID(\AppBundle\Entity\InfoPublicidad $PUBLICIDADID = null)
    {
        $this->PUBLICIDADID = $PUBLICIDADID;

        return $this;
    }

    /**
     * Get PUBLICIDADID
     *
     * @return \AppBundle\Entity\InfoPublicidad
     */
    public function getPUBLICIDADID()
    {
        return $this->PUBLICIDADID;
    }

    /**
     * Set TIPOCOMIDAID
     *
     * @param \AppBundle\Entity\AdmiTipoComida $TIPOCOMIDAID
     *
     * @return InfoPublicidadComida
     */
    public function setTIPOCOMIDAID(\AppBundle\Entity\AdmiTipoComida $TIPOCOMIDAID = null)
    {
        $this->TIPO_COMIDAID = $TIPOCOMIDAID;

        return $this;
    }

    /**
     * Get TIPOCOMIDAID
     *
     * @return \AppBundle\Entity\AdmiTipoComida
     */
    public function getTIPOCOMIDAID()
    {
        return $this->TIPO_COMIDAID;
    }
}
