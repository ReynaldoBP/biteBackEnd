<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoRespuesta
 *
 * @ORM\Table(name="INFO_RESPUESTA")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoRespuestaRepository")
 */
class InfoRespuesta
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_RESPUESTA", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var InfoPregunta
    *
    * @ORM\ManyToOne(targetEntity="InfoPregunta")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="PREGUNTA_ID", referencedColumnName="ID_PREGUNTA")
    * })
    */
    private $PREGUNTA_ID;

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
    * @var InfoContenidoSubido
    *
    * @ORM\ManyToOne(targetEntity="InfoContenidoSubido")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="CONTENIDO_ID", referencedColumnName="ID_CONTENIDO_SUBIDO")
    * })
    */
    private $CONTENIDO_ID;
    
    /**
     * @var string
     *
     * @ORM\Column(name="RESPUESTA", type="string", length=255, nullable=true)
     */
    private $RESPUESTA;

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
     * Set RESPUESTA
     *
     * @param string $RESPUESTA
     *
     * @return InfoRespuesta
     */
    public function setRESPUESTA($RESPUESTA)
    {
        $this->RESPUESTA = $RESPUESTA;

        return $this;
    }

    /**
     * Get RESPUESTA
     *
     * @return string
     */
    public function getRESPUESTA()
    {
        return $this->RESPUESTA;
    }

    /**
     * Set eSTADO
     *
     * @param string $eSTADO
     *
     * @return InfoRespuesta
     */
    public function setESTADO($eSTADO)
    {
        $this->ESTADO = $eSTADO;

        return $this;
    }

    /**
     * Get eSTADO
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
     * @return InfoRespuesta
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
     * @return InfoRespuesta
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
     * @return InfoRespuesta
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
     * @return InfoRespuesta
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
     * Set CLIENTEID
     *
     * @param \AppBundle\Entity\InfoCliente $CLIENTEID
     *
     * @return InfoRespuesta
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
     * Set PREGUNTAID
     *
     * @param \AppBundle\Entity\InfoPregunta $PREGUNTAID
     *
     * @return InfoRespuesta
     */
    public function setPREGUNTAID(\AppBundle\Entity\InfoPregunta $PREGUNTAID = null)
    {
        $this->PREGUNTA_ID = $PREGUNTAID;

        return $this;
    }

    /**
     * Get PREGUNTAID
     *
     * @return \AppBundle\Entity\InfoPregunta
     */
    public function getPREGUNTAID()
    {
        return $this->PREGUNTA_ID;
    }

    /**
     * Set CONTENIDOID
     *
     * @param \AppBundle\Entity\InfoContenidoSubido $CONTENIDOID
     *
     * @return InfoRespuesta
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
}
