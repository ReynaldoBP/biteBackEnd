<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmiPais
 *
 * @ORM\Table(name="ADMI_PAIS")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaisRepository")
 */
class AdmiPais
{
    /**
     * @var int
     *
     * @ORM\Column(name="PAIS_CODIGO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="PAIS_NOMBRE", type="string", length=52)
     */
    private $PAIS_NOMBRE;

    /**
     * @var string
     *
     * @ORM\Column(name="PAIS_CONTINENTE", type="string", length=50, nullable=true)
     */
    private $PAIS_CONTINENTE;

    /**
     * @var string
     *
     * @ORM\Column(name="PAIS_REGION", type="string", length=26, nullable=true)
     */
    private $PAIS_REGION;

    /**
     * @var string
     *
     * @ORM\Column(name="PAIS_NOMBRE_LOCAL", type="string", length=45, nullable=true)
     */
    private $PAIS_NOMBRE_LOCAL;

    /**
     * @var int
     *
     * @ORM\Column(name="PAIS_CAPITAL", type="integer", nullable=true)
     */
    private $PAIS_CAPITAL;

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
     * Set PAIS_NOMBRE
     *
     * @param string $PAIS_NOMBRE
     *
     * @return AdmiPais
     */
    public function setPAIS_NOMBRE($PAIS_NOMBRE)
    {
        $this->PAIS_NOMBRE = $PAIS_NOMBRE;

        return $this;
    }

    /**
     * Get PAIS_NOMBRE
     *
     * @return string
     */
    public function getPAIS_NOMBRE()
    {
        return $this->PAIS_NOMBRE;
    }

    /**
     * Set PAIS_CONTINENTE
     *
     * @param string $PAIS_CONTINENTE
     *
     * @return AdmiPais
     */
    public function setPAIS_CONTINENTE($PAIS_CONTINENTE)
    {
        $this->PAIS_CONTINENTE = $PAIS_CONTINENTE;

        return $this;
    }

    /**
     * Get PAIS_CONTINENTE
     *
     * @return string
     */
    public function getPAIS_CONTINENTE()
    {
        return $this->PAIS_CONTINENTE;
    }

    /**
     * Set PAIS_REGION
     *
     * @param string $PAIS_REGION
     *
     * @return AdmiPais
     */
    public function setPAIS_REGION($PAIS_REGION)
    {
        $this->PAIS_REGION = $PAIS_REGION;

        return $this;
    }

    /**
     * Get PAIS_REGION
     *
     * @return string
     */
    public function getPAIS_REGION()
    {
        return $this->PAIS_REGION;
    }

    /**
     * Set PAIS_NOMBRE_LOCAL
     *
     * @param string $PAIS_NOMBRE_LOCAL
     *
     * @return AdmiPais
     */
    public function setPAIS_NOMBRE_LOCAL($PAIS_NOMBRE_LOCAL)
    {
        $this->PAIS_NOMBRE_LOCAL = $PAIS_NOMBRE_LOCAL;

        return $this;
    }

    /**
     * Get PAIS_NOMBRE_LOCAL
     *
     * @return string
     */
    public function getPAIS_NOMBRE_LOCAL()
    {
        return $this->PAIS_NOMBRE_LOCAL;
    }

    /**
     * Set PAIS_CAPITAL
     *
     * @param integer $PAIS_CAPITAL
     *
     * @return AdmiPais
     */
    public function setPAIS_CAPITAL($PAIS_CAPITAL)
    {
        $this->PAIS_CAPITAL = $PAIS_CAPITAL;

        return $this;
    }

    /**
     * Get PAIS_CAPITAL
     *
     * @return int
     */
    public function getPAIS_CAPITAL()
    {
        return $this->PAIS_CAPITAL;
    }

    /**
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return AdmiPais
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
     * Set pAISNOMBRE
     *
     * @param string $pAISNOMBRE
     *
     * @return AdmiPais
     */
    public function setPAISNOMBRE($pAISNOMBRE)
    {
        $this->PAIS_NOMBRE = $pAISNOMBRE;

        return $this;
    }

    /**
     * Get pAISNOMBRE
     *
     * @return string
     */
    public function getPAISNOMBRE()
    {
        return $this->PAIS_NOMBRE;
    }

    /**
     * Set pAISCONTINENTE
     *
     * @param string $pAISCONTINENTE
     *
     * @return AdmiPais
     */
    public function setPAISCONTINENTE($pAISCONTINENTE)
    {
        $this->PAIS_CONTINENTE = $pAISCONTINENTE;

        return $this;
    }

    /**
     * Get pAISCONTINENTE
     *
     * @return string
     */
    public function getPAISCONTINENTE()
    {
        return $this->PAIS_CONTINENTE;
    }

    /**
     * Set pAISREGION
     *
     * @param string $pAISREGION
     *
     * @return AdmiPais
     */
    public function setPAISREGION($pAISREGION)
    {
        $this->PAIS_REGION = $pAISREGION;

        return $this;
    }

    /**
     * Get pAISREGION
     *
     * @return string
     */
    public function getPAISREGION()
    {
        return $this->PAIS_REGION;
    }

    /**
     * Set pAISNOMBRELOCAL
     *
     * @param string $pAISNOMBRELOCAL
     *
     * @return AdmiPais
     */
    public function setPAISNOMBRELOCAL($pAISNOMBRELOCAL)
    {
        $this->PAIS_NOMBRE_LOCAL = $pAISNOMBRELOCAL;

        return $this;
    }

    /**
     * Get pAISNOMBRELOCAL
     *
     * @return string
     */
    public function getPAISNOMBRELOCAL()
    {
        return $this->PAIS_NOMBRE_LOCAL;
    }

    /**
     * Set pAISCAPITAL
     *
     * @param integer $pAISCAPITAL
     *
     * @return AdmiPais
     */
    public function setPAISCAPITAL($pAISCAPITAL)
    {
        $this->PAIS_CAPITAL = $pAISCAPITAL;

        return $this;
    }

    /**
     * Get pAISCAPITAL
     *
     * @return integer
     */
    public function getPAISCAPITAL()
    {
        return $this->PAIS_CAPITAL;
    }
}
