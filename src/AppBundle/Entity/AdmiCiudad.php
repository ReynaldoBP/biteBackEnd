<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmiCiudad
 *
 * @ORM\Table(name="ADMI_CIUDAD")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CiudadRepository")
 */
class AdmiCiudad
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CIUDAD", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="CIUDAD_NOMBRE", type="string", length=35)
     */
    private $CIUDAD_NOMBRE;

    /**
     * @var string
     *
     * @ORM\Column(name="PAIS_CODIGO", type="string", length=3)
     */
    private $PAIS_CODIGO;

    /**
     * @var string
     *
     * @ORM\Column(name="CIUDAD_DISTRITO", type="string", length=20, nullable=true)
     */
    private $CIUDAD_DISTRITO;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO", type="string", length=50)
     */
    private $ESTADO;


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
     * Set CIUDAD_NOMBRE
     *
     * @param string $CIUDAD_NOMBRE
     *
     * @return AdmiCiudad
     */
    public function setCIUDAD_NOMBRE($CIUDAD_NOMBRE)
    {
        $this->CIUDAD_NOMBRE = $CIUDAD_NOMBRE;

        return $this;
    }

    /**
     * Get CIUDAD_NOMBRE
     *
     * @return string
     */
    public function getCIUDAD_NOMBRE()
    {
        return $this->CIUDAD_NOMBRE;
    }

    /**
     * Set PAIS_CODIGO
     *
     * @param string $PAIS_CODIGO
     *
     * @return AdmiCiudad
     */
    public function setPAIS_CODIGO($PAIS_CODIGO)
    {
        $this->PAIS_CODIGO = $PAIS_CODIGO;

        return $this;
    }

    /**
     * Get PAIS_CODIGO
     *
     * @return string
     */
    public function getPAIS_CODIGO()
    {
        return $this->PAIS_CODIGO;
    }

    /**
     * Set CIUDAD_DISTRITO
     *
     * @param string $CIUDAD_DISTRITO
     *
     * @return AdmiCiudad
     */
    public function setCIUDAD_DISTRITO($CIUDAD_DISTRITO)
    {
        $this->CIUDAD_DISTRITO = $CIUDAD_DISTRITO;

        return $this;
    }

    /**
     * Get CIUDAD_DISTRITO
     *
     * @return string
     */
    public function getCIUDAD_DISTRITO()
    {
        return $this->CIUDAD_DISTRITO;
    }

    /**
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return AdmiCiudad
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
     * Set cIUDADNOMBRE
     *
     * @param string $cIUDADNOMBRE
     *
     * @return AdmiCiudad
     */
    public function setCIUDADNOMBRE($cIUDADNOMBRE)
    {
        $this->CIUDAD_NOMBRE = $cIUDADNOMBRE;

        return $this;
    }

    /**
     * Get cIUDADNOMBRE
     *
     * @return string
     */
    public function getCIUDADNOMBRE()
    {
        return $this->CIUDAD_NOMBRE;
    }

    /**
     * Set pAISCODIGO
     *
     * @param string $pAISCODIGO
     *
     * @return AdmiCiudad
     */
    public function setPAISCODIGO($pAISCODIGO)
    {
        $this->PAIS_CODIGO = $pAISCODIGO;

        return $this;
    }

    /**
     * Get pAISCODIGO
     *
     * @return string
     */
    public function getPAISCODIGO()
    {
        return $this->PAIS_CODIGO;
    }

    /**
     * Set cIUDADDISTRITO
     *
     * @param string $cIUDADDISTRITO
     *
     * @return AdmiCiudad
     */
    public function setCIUDADDISTRITO($cIUDADDISTRITO)
    {
        $this->CIUDAD_DISTRITO = $cIUDADDISTRITO;

        return $this;
    }

    /**
     * Get cIUDADDISTRITO
     *
     * @return string
     */
    public function getCIUDADDISTRITO()
    {
        return $this->CIUDAD_DISTRITO;
    }
}
