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
    * @var AdmiRegion
    *
    * @ORM\ManyToOne(targetEntity="AdmiRegion")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="REGION_ID", referencedColumnName="ID_REGION")
    * })
    */
    private $REGION_ID;

    /**
     * @var string
     *
     * @ORM\Column(name="PROVINCIA_NOMBRE", type="string", length=255)
     */
    private $PROVINCIANOMBRE;

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
     * Set rEGIONID
     *
     * @param \AppBundle\Entity\AdmiRegion $rEGIONID
     *
     * @return AdmiProvincia
     */
    public function setREGIONID(\AppBundle\Entity\AdmiRegion $rEGIONID = null)
    {
        $this->REGION_ID = $rEGIONID;

        return $this;
    }

    /**
     * Get rEGIONID
     *
     * @return \AppBundle\Entity\AdmiRegion
     */
    public function getREGIONID()
    {
        return $this->REGION_ID;
    }
}
