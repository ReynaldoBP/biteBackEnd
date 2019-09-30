<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoPromocionHistorial
 *
 * @ORM\Table(name="INFO_CLIENTE_PROMOCION_HISTORIAL")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoPromocionHistorialRepository")
 */
class InfoPromocionHistorial
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CLIENTE_PUNTO_HISTORIAL", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var InfoPromocion
    *
    * @ORM\ManyToOne(targetEntity="InfoPromocion")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="PROMOCION_ID", referencedColumnName="ID_PROMOCION")
    * })
    */
    private $PROMOCION_ID;

    /**
    * @var InfoCliente
    *
    * @ORM\ManyToOne(targetEntity="InfoCliente")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="CLIENTE_ID", referencedColumnName="ID_CLIENTE")
    * })
    */
    private $CLIENTE_ID;

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
     * @return InfoPromocionHistorial
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
     * @return InfoPromocionHistorial
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
     * @return InfoPromocionHistorial
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
     * @return InfoPromocionHistorial
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
     * @return InfoPromocionHistorial
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
     * Set PROMOCIONID
     *
     * @param \AppBundle\Entity\InfoPromocion $PROMOCIONID
     *
     * @return InfoPromocionHistorial
     */
    public function setPROMOCIONID(\AppBundle\Entity\InfoPromocion $PROMOCIONID = null)
    {
        $this->PROMOCION_ID = $PROMOCIONID;

        return $this;
    }

    /**
     * Get PROMOCIONID
     *
     * @return \AppBundle\Entity\InfoPromocion
     */
    public function getPROMOCIONID()
    {
        return $this->PROMOCION_ID;
    }

    /**
     * Set CLIENTEID
     *
     * @param \AppBundle\Entity\InfoCliente $CLIENTEID
     *
     * @return InfoPromocionHistorial
     */
    public function setCLIENTEID(\AppBundle\Entity\InfoCliente $CLIENTEID = null)
    {
        $this->CLIENTE_ID = $CLIENTEID;

        return $this;
    }

    /**
     * Get CLIENTEID
     *
     * @return \AppBundle\Entity\InfoCliente
     */
    public function getCLIENTEID()
    {
        return $this->CLIENTE_ID;
    }
}
