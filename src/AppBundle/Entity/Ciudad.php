<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ciudad
 *
 * @ORM\Table(name="ciudad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CiudadRepository")
 */
class Ciudad
{
    /**
     * @var int
     *
     * @ORM\Column(name="CiudadID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="CiudadNombre", type="string", length=35)
     */
    private $ciudadNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="PaisCodigo", type="string", length=3)
     */
    private $paisCodigo;

    /**
     * @var string
     *
     * @ORM\Column(name="CiudadDistrito", type="string", length=20, nullable=true)
     */
    private $ciudadDistrito;

    /**
     * @var int
     *
     * @ORM\Column(name="CiudadPoblacion", type="integer", nullable=true)
     */
    private $ciudadPoblacion;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO", type="string", length=50)
     */
    private $eSTADO;


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
     * Set ciudadNombre
     *
     * @param string $ciudadNombre
     *
     * @return Ciudad
     */
    public function setCiudadNombre($ciudadNombre)
    {
        $this->ciudadNombre = $ciudadNombre;

        return $this;
    }

    /**
     * Get ciudadNombre
     *
     * @return string
     */
    public function getCiudadNombre()
    {
        return $this->ciudadNombre;
    }

    /**
     * Set paisCodigo
     *
     * @param string $paisCodigo
     *
     * @return Ciudad
     */
    public function setPaisCodigo($paisCodigo)
    {
        $this->paisCodigo = $paisCodigo;

        return $this;
    }

    /**
     * Get paisCodigo
     *
     * @return string
     */
    public function getPaisCodigo()
    {
        return $this->paisCodigo;
    }

    /**
     * Set ciudadDistrito
     *
     * @param string $ciudadDistrito
     *
     * @return Ciudad
     */
    public function setCiudadDistrito($ciudadDistrito)
    {
        $this->ciudadDistrito = $ciudadDistrito;

        return $this;
    }

    /**
     * Get ciudadDistrito
     *
     * @return string
     */
    public function getCiudadDistrito()
    {
        return $this->ciudadDistrito;
    }

    /**
     * Set ciudadPoblacion
     *
     * @param integer $ciudadPoblacion
     *
     * @return Ciudad
     */
    public function setCiudadPoblacion($ciudadPoblacion)
    {
        $this->ciudadPoblacion = $ciudadPoblacion;

        return $this;
    }

    /**
     * Get ciudadPoblacion
     *
     * @return int
     */
    public function getCiudadPoblacion()
    {
        return $this->ciudadPoblacion;
    }

    /**
     * Set eSTADO
     *
     * @param string $eSTADO
     *
     * @return Ciudad
     */
    public function setESTADO($eSTADO)
    {
        $this->eSTADO = $eSTADO;

        return $this;
    }

    /**
     * Get eSTADO
     *
     * @return string
     */
    public function getESTADO()
    {
        return $this->eSTADO;
    }
}

