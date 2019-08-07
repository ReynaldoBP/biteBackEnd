<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmiParroquia
 *
 * @ORM\Table(name="ADMI_PARROQUIA")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdmiParroquiaRepository")
 */
class AdmiParroquia
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PARROQUIA", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var AdmiCiudad
    *
    * @ORM\ManyToOne(targetEntity="AdmiCiudad")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="CIUDAD_ID", referencedColumnName="ID_CIUDAD")
    * })
    */
    private $CIUDAD_ID;

    /**
     * @var string
     *
     * @ORM\Column(name="PARROQUIA_NOMBRE", type="string", length=255)
     */
    private $PARROQUIANOMBRE;

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
     * Set PARROQUIANOMBRE
     *
     * @param string $PARROQUIANOMBRE
     *
     * @return AdmiParroquia
     */
    public function setPARROQUIANOMBRE($PARROQUIANOMBRE)
    {
        $this->PARROQUIANOMBRE = $PARROQUIANOMBRE;

        return $this;
    }

    /**
     * Get PARROQUIANOMBRE
     *
     * @return string
     */
    public function getPARROQUIANOMBRE()
    {
        return $this->PARROQUIANOMBRE;
    }

    /**
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return AdmiParroquia
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
     * Set cIUDADID
     *
     * @param \AppBundle\Entity\AdmiCiudad $cIUDADID
     *
     * @return AdmiParroquia
     */
    public function setCIUDADID(\AppBundle\Entity\AdmiCiudad $cIUDADID = null)
    {
        $this->CIUDAD_ID = $cIUDADID;

        return $this;
    }

    /**
     * Get cIUDADID
     *
     * @return \AppBundle\Entity\AdmiCiudad
     */
    public function getCIUDADID()
    {
        return $this->CIUDAD_ID;
    }
}
