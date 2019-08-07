<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmiRegion
 *
 * @ORM\Table(name="ADMI_REGION")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdmiRegionRepository")
 */
class AdmiRegion
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_REGION", type="integer")
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
     * @ORM\Column(name="REGION_NOMBRE", type="string", length=255)
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
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return AdmiRegion
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
     * Set REGION_NOMBRE
     *
     * @param string $REGION_NOMBRE
     *
     * @return AdmiRegion
     */
    public function setREGION_NOMBRE($REGION_NOMBRE)
    {
        $this->REGION_NOMBRE = $REGION_NOMBRE;

        return $this;
    }

    /**
     * Get REGION_NOMBRE
     *
     * @return string
     */
    public function getREGION_NOMBRE()
    {
        return $this->REGION_NOMBRE;
    }

    /**
     * Set PAIS_ID
     *
     * @param \AppBundle\Entity\AdmiPais $PAIS_ID
     *
     * @return AdmiRegion
     */
    public function setPAIS_ID(\AppBundle\Entity\AdmiPais $PAIS_ID = null)
    {
        $this->PAIS_ID = $PAIS_ID;

        return $this;
    }

    /**
     * Get PAIS_ID
     *
     * @return \AppBundle\Entity\AdmiPais
     */
    public function getPAIS_ID()
    {
        return $this->PAIS_ID;
    }
}
