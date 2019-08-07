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
    * @var AdmiProvincia
    *
    * @ORM\ManyToOne(targetEntity="AdmiProvincia")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="PROVINCIA_ID", referencedColumnName="ID_PROVINCIA")
    * })
    */

    private $PROVINCIA_ID;
    /**
     * @var string
     *
     * @ORM\Column(name="CIUDAD_NOMBRE", type="string", length=35)
     */
    private $CIUDAD_NOMBRE;

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
     * Set PROVINCIA_ID
     *
     * @param \AppBundle\Entity\AdmiProvincia $PROVINCIA_ID
     *
     * @return AdmiCiudad
     */
    public function setPROVINCIA_ID(\AppBundle\Entity\AdmiProvincia $PROVINCIA_ID = null)
    {
        $this->PROVINCIA_ID = $PROVINCIA_ID;

        return $this;
    }

    /**
     * Get PROVINCIA_ID
     *
     * @return \AppBundle\Entity\AdmiProvincia
     */
    public function getPROVINCIA_ID()
    {
        return $this->PROVINCIA_ID;
    }
}
