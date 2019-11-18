<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoVistaPublicidad
 *
 * @ORM\Table(name="INFO_VISTA_PUBLICIDAD")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoVistaPublicidadRepository")
 */
class InfoVistaPublicidad
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_VISTA_PUBLICIDAD", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
    * @var InfoRestaurante
    *
    * @ORM\ManyToOne(targetEntity="InfoRestaurante")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="RESTAURANTE_ID", referencedColumnName="ID_RESTAURANTE")
    * })
    */
    private $RESTAURANTE_ID;

    /**
    * @var InfoPublicidad
    *
    * @ORM\ManyToOne(targetEntity="InfoPublicidad")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="PUBLICIDAD_ID", referencedColumnName="ID_PUBLICIDAD")
    * })
    */
    private $PUBLICIDAD_ID;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO", type="string", length=100, nullable=true)
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
     * @return InfoVistaPublicidad
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
     * @return InfoVistaPublicidad
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
     * @return InfoVistaPublicidad
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
     * Set CLIENTEID
     *
     * @param \AppBundle\Entity\InfoCliente $CLIENTEID
     *
     * @return InfoVistaPublicidad
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

    /**
     * Set RESTAURANTEID
     *
     * @param \AppBundle\Entity\InfoRestaurante $RESTAURANTEID
     *
     * @return InfoVistaPublicidad
     */
    public function setRESTAURANTEID(\AppBundle\Entity\InfoRestaurante $RESTAURANTEID = null)
    {
        $this->RESTAURANTE_ID = $RESTAURANTEID;

        return $this;
    }

    /**
     * Get RESTAURANTEID
     *
     * @return \AppBundle\Entity\InfoRestaurante
     */
    public function getRESTAURANTEID()
    {
        return $this->RESTAURANTE_ID;
    }

    /**
     * Set PUBLICIDADID
     *
     * @param \AppBundle\Entity\InfoPublicidad $PUBLICIDADID
     *
     * @return InfoVistaPublicidad
     */
    public function setPUBLICIDADID(\AppBundle\Entity\InfoPublicidad $PUBLICIDADID = null)
    {
        $this->PUBLICIDAD_ID = $PUBLICIDADID;

        return $this;
    }

    /**
     * Get PUBLICIDADID
     *
     * @return \AppBundle\Entity\InfoPublicidad
     */
    public function getPUBLICIDADID()
    {
        return $this->PUBLICIDAD_ID;
    }
}
