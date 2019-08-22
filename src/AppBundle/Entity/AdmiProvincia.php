<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmiProvincia
 *
 * @ORM\Table(name="ADMI_PROVINCIA")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdmiProvinciaRepository")
 */
class AdmiProvincia
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PROVINCIA", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var AdmiPais
    *
    * @ORM\ManyToOne(targetEntity="AdmiPais")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="PAIS_ID", referencedColumnName="ID_PAIS")
    * })
    */
    private $PAIS_ID;

    /**
     * @var string
     *
     * @ORM\Column(name="PROVINCIA_NOMBRE", type="string", length=255)
     */
    private $PROVINCIANOMBRE;

    /**
     * @var string
     *
     * @ORM\Column(name="REGION_NOMBRE", type="string", length=50)
     */
    private $REGION_NOMBRE;

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
     * Set PROVINCIANOMBRE
     *
     * @param string $PROVINCIANOMBRE
     *
     * @return AdmiProvincia
     */
    public function setPROVINCIANOMBRE($PROVINCIANOMBRE)
    {
        $this->PROVINCIANOMBRE = $PROVINCIANOMBRE;

        return $this;
    }

    /**
     * Get PROVINCIANOMBRE
     *
     * @return string
     */
    public function getPROVINCIANOMBRE()
    {
        return $this->PROVINCIANOMBRE;
    }

    /**
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return AdmiProvincia
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
     * Set PAISID
     *
     * @param \AppBundle\Entity\AdmiPais $PAISID
     *
     * @return AdmiProvincia
     */
    public function setPAISID(\AppBundle\Entity\AdmiPais $PAISID = null)
    {
        $this->PAIS_ID = $PAISID;

        return $this;
    }

    /**
     * Get PAISID
     *
     * @return \AppBundle\Entity\AdmiPais
     */
    public function getPAISID()
    {
        return $this->PAIS_ID;
    }

    /**
     * Set REGIONNOMBRE
     *
     * @param string $REGIONNOMBRE
     *
     * @return AdmiProvincia
     */
    public function setREGIONNOMBRE($REGIONNOMBRE)
    {
        $this->REGION_NOMBRE = $REGIONNOMBRE;

        return $this;
    }

    /**
     * Get REGIONNOMBRE
     *
     * @return string
     */
    public function getREGIONNOMBRE()
    {
        return $this->REGION_NOMBRE;
    }
}
