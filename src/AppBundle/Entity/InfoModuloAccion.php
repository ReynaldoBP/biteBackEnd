<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoModuloAccion
 *
 * @ORM\Table(name="INFO_MODULO_ACCION")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoModuloAccionRepository")
 */
class InfoModuloAccion
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_MODULO_ACCION", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var AdmiModulo
    *
    * @ORM\ManyToOne(targetEntity="AdmiModulo")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="MODULO_ID", referencedColumnName="ID_MODULO")
    * })
    */
    private $MODULO_ID;

    /**
    * @var AdmiAccion
    *
    * @ORM\ManyToOne(targetEntity="AdmiAccion")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="ACCION_ID", referencedColumnName="ID_ACCION")
    * })
    */
    private $ACCION_ID;

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
     * @return InfoModuloAccion
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
     * @return InfoModuloAccion
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
     * @return InfoModuloAccion
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
     * @return InfoModuloAccion
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
     * @return InfoModuloAccion
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
     * Set MODULOID
     *
     * @param \AppBundle\Entity\AdmiModulo $MODULOID
     *
     * @return InfoModuloAccion
     */
    public function setMODULOID(\AppBundle\Entity\AdmiModulo $MODULOID = null)
    {
        $this->MODULO_ID = $MODULOID;

        return $this;
    }

    /**
     * Get MODULOID
     *
     * @return \AppBundle\Entity\AdmiModulo
     */
    public function getMODULOID()
    {
        return $this->MODULO_ID;
    }

    /**
     * Set ACCIONID
     *
     * @param \AppBundle\Entity\AdmiAccion $ACCIONID
     *
     * @return InfoModuloAccion
     */
    public function setACCIONID(\AppBundle\Entity\AdmiAccion $ACCIONID = null)
    {
        $this->ACCION_ID = $ACCIONID;

        return $this;
    }

    /**
     * Get ACCIONID
     *
     * @return \AppBundle\Entity\AdmiAccion
     */
    public function getACCIONID()
    {
        return $this->ACCION_ID;
    }
}
