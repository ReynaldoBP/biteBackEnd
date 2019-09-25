<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoPregunta
 *
 * @ORM\Table(name="INFO_PREGUNTA")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoPreguntaRepository")
 */
class InfoPregunta
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PREGUNTA", type="integer")
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
    * @var InfoOpcionRespuesta
    *
    * @ORM\ManyToOne(targetEntity="InfoOpcionRespuesta")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="OPCION_RESPUESTA_ID", referencedColumnName="ID_OPCION_RESPUESTA")
    * })
    */
    private $OPCION_RESPUESTA_ID;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPCION", type="string", length=255)
     */
    private $DESCRIPCION;

    /**
     * @var string
     *
     * @ORM\Column(name="EN_CENTRO_COMERCIAL", type="string", length=2)
     */
    private $EN_CENTRO_COMERCIAL;

    /**
     * @var string
     *
     * @ORM\Column(name="OBLIGATORIA", type="string", length=50, nullable=true)
     */
    private $OBLIGATORIA;

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
     * Set DESCRIPCION
     *
     * @param string $DESCRIPCION
     *
     * @return InfoPregunta
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
     * Set OBLIGATORIA
     *
     * @param string $OBLIGATORIA
     *
     * @return InfoPregunta
     */
    public function setOBLIGATORIA($OBLIGATORIA)
    {
        $this->OBLIGATORIA = $OBLIGATORIA;

        return $this;
    }

    /**
     * Get OBLIGATORIA
     *
     * @return string
     */
    public function getOBLIGATORIA()
    {
        return $this->OBLIGATORIA;
    }

    /**
     * Set eSTADO
     *
     * @param string $eSTADO
     *
     * @return InfoPregunta
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
     * Set uSRCREACION
     *
     * @param string $uSRCREACION
     *
     * @return InfoPregunta
     */
    public function setUSRCREACION($uSRCREACION)
    {
        $this->USRCREACION = $uSRCREACION;

        return $this;
    }

    /**
     * Get uSRCREACION
     *
     * @return string
     */
    public function getUSRCREACION()
    {
        return $this->USRCREACION;
    }

    /**
     * Set fECREACION
     *
     * @param \DateTime $fECREACION
     *
     * @return InfoPregunta
     */
    public function setFECREACION($fECREACION)
    {
        $this->FECREACION = $fECREACION;

        return $this;
    }

    /**
     * Get fECREACION
     *
     * @return \DateTime
     */
    public function getFECREACION()
    {
        return $this->FECREACION;
    }

    /**
     * Set uSRMODIFICACION
     *
     * @param string $uSRMODIFICACION
     *
     * @return InfoPregunta
     */
    public function setUSRMODIFICACION($uSRMODIFICACION)
    {
        $this->USRMODIFICACION = $uSRMODIFICACION;

        return $this;
    }

    /**
     * Get uSRMODIFICACION
     *
     * @return string
     */
    public function getUSRMODIFICACION()
    {
        return $this->USRMODIFICACION;
    }

    /**
     * Set fEMODIFICACION
     *
     * @param \DateTime $fEMODIFICACION
     *
     * @return InfoPregunta
     */
    public function setFEMODIFICACION($fEMODIFICACION)
    {
        $this->FEMODIFICACION = $fEMODIFICACION;

        return $this;
    }

    /**
     * Get fEMODIFICACION
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
     * @return InfoPregunta
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
     * Set OPCIONRESPUESTAID
     *
     * @param \AppBundle\Entity\InfoOpcionRespuesta $OPCIONRESPUESTAID
     *
     * @return InfoPregunta
     */
    public function setOPCIONRESPUESTAID(\AppBundle\Entity\InfoOpcionRespuesta $OPCIONRESPUESTAID = null)
    {
        $this->OPCION_RESPUESTA_ID = $OPCIONRESPUESTAID;

        return $this;
    }

    /**
     * Get OPCIONRESPUESTAID
     *
     * @return \AppBundle\Entity\InfoOpcionRespuesta
     */
    public function getOPCIONRESPUESTAID()
    {
        return $this->OPCION_RESPUESTA_ID;
    }

    /**
     * Set ENCENTROCOMERCIAL
     *
     * @param string $ENCENTROCOMERCIAL
     *
     * @return InfoPregunta
     */
    public function setENCENTROCOMERCIAL($ENCENTROCOMERCIAL)
    {
        $this->EN_CENTRO_COMERCIAL = $ENCENTROCOMERCIAL;

        return $this;
    }

    /**
     * Get ENCENTROCOMERCIAL
     *
     * @return string
     */
    public function getENCENTROCOMERCIAL()
    {
        return $this->EN_CENTRO_COMERCIAL;
    }
}
