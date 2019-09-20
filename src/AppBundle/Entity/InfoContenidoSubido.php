<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoContenidoSubido
 *
 * @ORM\Table(name="INFO_CONTENIDO_SUBIDO")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoContenidoSubidoRepository")
 */
class InfoContenidoSubido
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CONTENIDO_SUBIDO", type="integer")
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
    * @var InfoClientePunto
    *
    * @ORM\ManyToOne(targetEntity="InfoClientePunto")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="CLIENTE_PUNTO_ID", referencedColumnName="ID_CLIENTE_PUNTO")
    * })
    */
    private $CLIENTE_PUNTO_ID;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPCION", type="string", length=255, nullable=true)
     */
    private $DESCRIPCION;

    /**
     * @var string
     *
     * @ORM\Column(name="IMAGEN", type="string", length=450)
     */
    private $IMAGEN;

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
     * Set DESCRIPCION
     *
     * @param string $DESCRIPCION
     *
     * @return InfoContenidoSubido
     */
    public function setDESCRIPCION($DESCRIPCION)
    {
        $this->DESCRIPCION = $DESCRIPCION;

        return $this;
    }

    /**
     * Get DESCRIPCION
     *
     * @return string
     */
    public function getDESCRIPCION()
    {
        return $this->DESCRIPCION;
    }

    /**
     * Set IMAGEN
     *
     * @param string $IMAGEN
     *
     * @return InfoContenidoSubido
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
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return InfoContenidoSubido
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
     * @return InfoContenidoSubido
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
     * @return InfoContenidoSubido
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
     * @return InfoContenidoSubido
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
     * @return InfoContenidoSubido
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
     * @return InfoContenidoSubido
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
     * Set CLIENTEPUNTOID
     *
     * @param \AppBundle\Entity\InfoClientePunto $CLIENTEPUNTOID
     *
     * @return InfoContenidoSubido
     */
    public function setCLIENTEPUNTOID(\AppBundle\Entity\InfoClientePunto $CLIENTEPUNTOID = null)
    {
        $this->CLIENTE_PUNTO_ID = $CLIENTEPUNTOID;

        return $this;
    }

    /**
     * Get CLIENTEPUNTOID
     *
     * @return \AppBundle\Entity\InfoClientePunto
     */
    public function getCLIENTEPUNTOID()
    {
        return $this->CLIENTE_PUNTO_ID;
    }
}
