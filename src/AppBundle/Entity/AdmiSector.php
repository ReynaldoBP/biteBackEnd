<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmiSector
 *
 * @ORM\Table(name="ADMI_SECTOR")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdmiSectorRepository")
 */
class AdmiSector
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_SECTOR", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var AdmiParroquia
    *
    * @ORM\ManyToOne(targetEntity="AdmiParroquia")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="PARROQUIA_ID", referencedColumnName="ID_PARROQUIA")
    * })
    */
    private $PARROQUIA_ID;

    /**
     * @var string
     *
     * @ORM\Column(name="SECTOR_NOMBRE", type="string", length=255)
     */
    private $SECTORNOMBRE;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO", type="string", length=255)
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
     * Set SECTORNOMBRE
     *
     * @param string $SECTORNOMBRE
     *
     * @return AdmiSector
     */
    public function setSECTORNOMBRE($SECTORNOMBRE)
    {
        $this->SECTORNOMBRE = $SECTORNOMBRE;

        return $this;
    }

    /**
     * Get SECTORNOMBRE
     *
     * @return string
     */
    public function getSECTORNOMBRE()
    {
        return $this->SECTORNOMBRE;
    }

    /**
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return AdmiSector
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
     * Set PARROQUIAID
     *
     * @param \AppBundle\Entity\AdmiParroquia $PARROQUIAID
     *
     * @return AdmiSector
     */
    public function setPARROQUIAID(\AppBundle\Entity\AdmiParroquia $PARROQUIAID = null)
    {
        $this->PARROQUIA_ID = $PARROQUIAID;

        return $this;
    }

    /**
     * Get PARROQUIAID
     *
     * @return \AppBundle\Entity\AdmiParroquia
     */
    public function getPARROQUIAID()
    {
        return $this->PARROQUIA_ID;
    }
}
