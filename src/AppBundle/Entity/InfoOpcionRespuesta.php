<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoOpcionRespuesta
 *
 * @ORM\Table(name="INFO_OPCION_RESPUESTA")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoOpcionRespuestaRepository")
 */
class InfoOpcionRespuesta
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_OPCION_RESPUESTA", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="TIPO_RESPUESTA", type="string", length=255)
     */
    private $TIPORESPUESTA;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPCION", type="string", length=100, nullable=true)
     */
    private $DESCRIPCION;


    /**
     * @var string
     *
     * @ORM\Column(name="VALOR", type="string", length=100, nullable=true)
     */
    private $VALOR;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO", type="string", length=255)
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
     * Set TIPORESPUESTA
     *
     * @param string $TIPORESPUESTA
     *
     * @return InfoOpcionRespuesta
     */
    public function setTIPORESPUESTA($TIPORESPUESTA)
    {
        $this->TIPORESPUESTA = $TIPORESPUESTA;

        return $this;
    }

    /**
     * Get TIPORESPUESTA
     *
     * @return string
     */
    public function getTIPORESPUESTA()
    {
        return $this->TIPORESPUESTA;
    }

    /**
     * Set DESCRIPCION
     *
     * @param string $DESCRIPCION
     *
     * @return InfoOpcionRespuesta
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
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return InfoOpcionRespuesta
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
     * @return InfoOpcionRespuesta
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
     * @return InfoOpcionRespuesta
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
     * @return InfoOpcionRespuesta
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
     * @return InfoOpcionRespuesta
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
     * Set VALOR
     *
     * @param string $VALOR
     *
     * @return InfoOpcionRespuesta
     */
    public function setVALOR($VALOR)
    {
        $this->VALOR = $VALOR;

        return $this;
    }

    /**
     * Get VALOR
     *
     * @return string
     */
    public function getVALOR()
    {
        return $this->VALOR;
    }
}
