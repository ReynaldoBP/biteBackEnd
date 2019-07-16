<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pais
 *
 * @ORM\Table(name="Pais")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaisRepository")
 */
class Pais
{
    /**
     * @var int
     *
     * @ORM\Column(name="PaisCodigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="PaisNombre", type="string", length=52)
     */
    private $paisNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="PaisContinente", type="string", length=50, nullable=true)
     */
    private $paisContinente;

    /**
     * @var string
     *
     * @ORM\Column(name="PaisRegion", type="string", length=26, nullable=true)
     */
    private $paisRegion;

    /**
     * @var float
     *
     * @ORM\Column(name="PaisArea", type="float", nullable=true)
     */
    private $paisArea;

    /**
     * @var int
     *
     * @ORM\Column(name="PaisIndependencia", type="smallint", nullable=true)
     */
    private $paisIndependencia;

    /**
     * @var int
     *
     * @ORM\Column(name="PaisPoblacion", type="integer", nullable=true)
     */
    private $paisPoblacion;

    /**
     * @var float
     *
     * @ORM\Column(name="PaisExpectativaDeVida", type="float", nullable=true)
     */
    private $paisExpectativaDeVida;

    /**
     * @var float
     *
     * @ORM\Column(name="PaisProductoInternoBruto", type="float", nullable=true)
     */
    private $paisProductoInternoBruto;

    /**
     * @var float
     *
     * @ORM\Column(name="PaisProductoInternoBrutoAntiguo", type="float", nullable=true)
     */
    private $paisProductoInternoBrutoAntiguo;

    /**
     * @var string
     *
     * @ORM\Column(name="PaisNombreLocal", type="string", length=45, nullable=true)
     */
    private $paisNombreLocal;

    /**
     * @var string
     *
     * @ORM\Column(name="PaisGobierno", type="string", length=45, nullable=true)
     */
    private $paisGobierno;

    /**
     * @var string
     *
     * @ORM\Column(name="PaisJefeDeEstado", type="string", length=60)
     */
    private $paisJefeDeEstado;

    /**
     * @var int
     *
     * @ORM\Column(name="PaisCapital", type="integer", nullable=true)
     */
    private $paisCapital;

    /**
     * @var string
     *
     * @ORM\Column(name="PaisCodigo2", type="string", length=2, nullable=true)
     */
    private $paisCodigo2;

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
     * Set paisNombre
     *
     * @param string $paisNombre
     *
     * @return Pais
     */
    public function setPaisNombre($paisNombre)
    {
        $this->paisNombre = $paisNombre;

        return $this;
    }

    /**
     * Get paisNombre
     *
     * @return string
     */
    public function getPaisNombre()
    {
        return $this->paisNombre;
    }

    /**
     * Set paisContinente
     *
     * @param string $paisContinente
     *
     * @return Pais
     */
    public function setPaisContinente($paisContinente)
    {
        $this->paisContinente = $paisContinente;

        return $this;
    }

    /**
     * Get paisContinente
     *
     * @return string
     */
    public function getPaisContinente()
    {
        return $this->paisContinente;
    }

    /**
     * Set paisRegion
     *
     * @param string $paisRegion
     *
     * @return Pais
     */
    public function setPaisRegion($paisRegion)
    {
        $this->paisRegion = $paisRegion;

        return $this;
    }

    /**
     * Get paisRegion
     *
     * @return string
     */
    public function getPaisRegion()
    {
        return $this->paisRegion;
    }

    /**
     * Set paisArea
     *
     * @param float $paisArea
     *
     * @return Pais
     */
    public function setPaisArea($paisArea)
    {
        $this->paisArea = $paisArea;

        return $this;
    }

    /**
     * Get paisArea
     *
     * @return float
     */
    public function getPaisArea()
    {
        return $this->paisArea;
    }

    /**
     * Set paisIndependencia
     *
     * @param integer $paisIndependencia
     *
     * @return Pais
     */
    public function setPaisIndependencia($paisIndependencia)
    {
        $this->paisIndependencia = $paisIndependencia;

        return $this;
    }

    /**
     * Get paisIndependencia
     *
     * @return int
     */
    public function getPaisIndependencia()
    {
        return $this->paisIndependencia;
    }

    /**
     * Set paisPoblacion
     *
     * @param integer $paisPoblacion
     *
     * @return Pais
     */
    public function setPaisPoblacion($paisPoblacion)
    {
        $this->paisPoblacion = $paisPoblacion;

        return $this;
    }

    /**
     * Get paisPoblacion
     *
     * @return int
     */
    public function getPaisPoblacion()
    {
        return $this->paisPoblacion;
    }

    /**
     * Set paisExpectativaDeVida
     *
     * @param float $paisExpectativaDeVida
     *
     * @return Pais
     */
    public function setPaisExpectativaDeVida($paisExpectativaDeVida)
    {
        $this->paisExpectativaDeVida = $paisExpectativaDeVida;

        return $this;
    }

    /**
     * Get paisExpectativaDeVida
     *
     * @return float
     */
    public function getPaisExpectativaDeVida()
    {
        return $this->paisExpectativaDeVida;
    }

    /**
     * Set paisProductoInternoBruto
     *
     * @param float $paisProductoInternoBruto
     *
     * @return Pais
     */
    public function setPaisProductoInternoBruto($paisProductoInternoBruto)
    {
        $this->paisProductoInternoBruto = $paisProductoInternoBruto;

        return $this;
    }

    /**
     * Get paisProductoInternoBruto
     *
     * @return float
     */
    public function getPaisProductoInternoBruto()
    {
        return $this->paisProductoInternoBruto;
    }

    /**
     * Set paisProductoInternoBrutoAntiguo
     *
     * @param float $paisProductoInternoBrutoAntiguo
     *
     * @return Pais
     */
    public function setPaisProductoInternoBrutoAntiguo($paisProductoInternoBrutoAntiguo)
    {
        $this->paisProductoInternoBrutoAntiguo = $paisProductoInternoBrutoAntiguo;

        return $this;
    }

    /**
     * Get paisProductoInternoBrutoAntiguo
     *
     * @return float
     */
    public function getPaisProductoInternoBrutoAntiguo()
    {
        return $this->paisProductoInternoBrutoAntiguo;
    }

    /**
     * Set paisNombreLocal
     *
     * @param string $paisNombreLocal
     *
     * @return Pais
     */
    public function setPaisNombreLocal($paisNombreLocal)
    {
        $this->paisNombreLocal = $paisNombreLocal;

        return $this;
    }

    /**
     * Get paisNombreLocal
     *
     * @return string
     */
    public function getPaisNombreLocal()
    {
        return $this->paisNombreLocal;
    }

    /**
     * Set paisGobierno
     *
     * @param string $paisGobierno
     *
     * @return Pais
     */
    public function setPaisGobierno($paisGobierno)
    {
        $this->paisGobierno = $paisGobierno;

        return $this;
    }

    /**
     * Get paisGobierno
     *
     * @return string
     */
    public function getPaisGobierno()
    {
        return $this->paisGobierno;
    }

    /**
     * Set paisJefeDeEstado
     *
     * @param string $paisJefeDeEstado
     *
     * @return Pais
     */
    public function setPaisJefeDeEstado($paisJefeDeEstado)
    {
        $this->paisJefeDeEstado = $paisJefeDeEstado;

        return $this;
    }

    /**
     * Get paisJefeDeEstado
     *
     * @return string
     */
    public function getPaisJefeDeEstado()
    {
        return $this->paisJefeDeEstado;
    }

    /**
     * Set paisCapital
     *
     * @param integer $paisCapital
     *
     * @return Pais
     */
    public function setPaisCapital($paisCapital)
    {
        $this->paisCapital = $paisCapital;

        return $this;
    }

    /**
     * Get paisCapital
     *
     * @return int
     */
    public function getPaisCapital()
    {
        return $this->paisCapital;
    }

    /**
     * Set paisCodigo2
     *
     * @param string $paisCodigo2
     *
     * @return Pais
     */
    public function setPaisCodigo2($paisCodigo2)
    {
        $this->paisCodigo2 = $paisCodigo2;

        return $this;
    }

    /**
     * Get paisCodigo2
     *
     * @return string
     */
    public function getPaisCodigo2()
    {
        return $this->paisCodigo2;
    }

    /**
     * Set eSTADO
     *
     * @param string $eSTADO
     *
     * @return Pais
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

