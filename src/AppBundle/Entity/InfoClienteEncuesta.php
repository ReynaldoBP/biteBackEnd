<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoClienteEncuesta
 *
 * @ORM\Table(name="INFO_CLIENTE_ENCUESTA")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoClienteEncuestaRepository")
 */
class InfoClienteEncuesta
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CLT_ENCUESTA", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var InfoEncuesta
    *
    * @ORM\ManyToOne(targetEntity="InfoEncuesta")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="ENCUESTA_ID", referencedColumnName="ID_ENCUESTA")
    * })
    */
    private $ENCUESTA_ID;

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
    * @var InfoSucursal
    *
    * @ORM\ManyToOne(targetEntity="InfoSucursal")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="SUCURSAL_ID", referencedColumnName="ID_SUCURSAL")
    * })
    */
    private $SUCURSAL_ID;

    /**
    * @var InfoContenidoSubido
    *
    * @ORM\ManyToOne(targetEntity="InfoContenidoSubido")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="CONTENIDO_ID", referencedColumnName="ID_CONTENIDO_SUBIDO")
    * })
    */
    private $CONTENIDO_ID;

    /**
     * @var int
     *
     * @ORM\Column(name="CANTIDAD_PUNTOS", type="integer")
     */
    private $CANTIDADPUNTOS;

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
     * @ORM\Column(name="FE_CREACION", type="datetime")
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
     * @return InfoClienteEncuesta
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
     * @return InfoClienteEncuesta
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
     * @return InfoClienteEncuesta
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
     * @return InfoClienteEncuesta
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
     * @return InfoClienteEncuesta
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
     * Set ENCUESTAID
     *
     * @param \AppBundle\Entity\InfoEncuesta $ENCUESTAID
     *
     * @return InfoClienteEncuesta
     */
    public function setENCUESTAID(\AppBundle\Entity\InfoEncuesta $ENCUESTAID = null)
    {
        $this->ENCUESTA_ID = $ENCUESTAID;

        return $this;
    }

    /**
     * Get ENCUESTAID
     *
     * @return \AppBundle\Entity\InfoEncuesta
     */
    public function getENCUESTAID()
    {
        return $this->ENCUESTA_ID;
    }

    /**
     * Set CLIENTEID
     *
     * @param \AppBundle\Entity\InfoCliente $CLIENTEID
     *
     * @return InfoClienteEncuesta
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
     * Set CONTENIDOID
     *
     * @param \AppBundle\Entity\InfoContenidoSubido $CONTENIDOID
     *
     * @return InfoClienteEncuesta
     */
    public function setCONTENIDOID(\AppBundle\Entity\InfoContenidoSubido $CONTENIDOID = null)
    {
        $this->CONTENIDO_ID = $CONTENIDOID;

        return $this;
    }

    /**
     * Get CONTENIDOID
     *
     * @return \AppBundle\Entity\InfoContenidoSubido
     */
    public function getCONTENIDOID()
    {
        return $this->CONTENIDO_ID;
    }

    /**
     * Set cANTIDADPUNTOS
     *
     * @param integer $cANTIDADPUNTOS
     *
     * @return InfoClienteEncuesta
     */
    public function setCANTIDADPUNTOS($cANTIDADPUNTOS)
    {
        $this->CANTIDADPUNTOS = $cANTIDADPUNTOS;

        return $this;
    }

    /**
     * Get cANTIDADPUNTOS
     *
     * @return integer
     */
    public function getCANTIDADPUNTOS()
    {
        return $this->CANTIDADPUNTOS;
    }

    /**
     * Set SUCURSALID
     *
     * @param \AppBundle\Entity\InfoSucursal $SUCURSALID
     *
     * @return InfoClienteEncuesta
     */
    public function setSUCURSALID(\AppBundle\Entity\InfoSucursal $SUCURSALID = null)
    {
        $this->SUCURSAL_ID = $SUCURSALID;

        return $this;
    }

    /**
     * Get SUCURSALID
     *
     * @return \AppBundle\Entity\InfoSucursal
     */
    public function getSUCURSALID()
    {
        return $this->SUCURSAL_ID;
    }
}
