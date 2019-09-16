<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * InfoPublicidadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InfoPublicidadRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Documentación para la función 'getPublicidadCriterio'
     * Método encargado de retornar todos las publicaciones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 05-09-2019
     * 
     * @return array  $arrayPublicidad
     * 
     */    
    public function getPublicidadCriterio($arrayParametros)
    {
        $intIdPublicidad    = $arrayParametros['intIdPublicidad'] ? $arrayParametros['intIdPublicidad']:'';
        $strDescrPublicidad = $arrayParametros['strDescrPublicidad'] ? $arrayParametros['strDescrPublicidad']:'';
        $strEstado          = $arrayParametros['strEstado'] ? $arrayParametros['strEstado']:array('ACTIVO','INACTIVO','ELIMINADO');
        $arrayPublicidad    = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        $objRsmBuilderCount = new ResultSetMappingBuilder($this->_em);
        $objQueryCount      = $this->_em->createNativeQuery(null, $objRsmBuilderCount);
        try
        {
            $strSelect      = "SELECT PB.ID_PUBLICIDAD,PB.DESCRIPCION, PB.EDAD_MAXIMA, PB.EDAD_MINIMA, PB.GENERO,
                               PB.PAIS,PB.PROVINCIA,PB.CIUDAD,PB.PARROQUIA,AC.CIUDAD_NOMBRE,AP.PARROQUIA_NOMBRE,
                               PB.ESTADO,PB.USR_CREACION,PB.FE_CREACION,PB.USR_MODIFICACION,PB.FE_MODIFICACION, 
                               PB.IMAGEN ";
            $strSelectCount = "SELECT COUNT(*) AS CANTIDAD ";
            $strFrom        = "FROM INFO_PUBLICIDAD PB 
                                LEFT JOIN ADMI_CIUDAD AC ON AC.ID_CIUDAD=PB.CIUDAD 
                                LEFT JOIN ADMI_PARROQUIA AP ON AP.ID_PARROQUIA=PB.PARROQUIA ";
            $strWhere       = "WHERE PB.ESTADO in (:ESTADO) ";
            $objQuery->setParameter("ESTADO",$strEstado);
            $objQueryCount->setParameter("ESTADO",$strEstado);
            if(!empty($intIdPublicidad))
            {
                $strWhere .= " AND PB.ID_PUBLICIDAD =:ID_PUBLICIDAD ";
                $objQuery->setParameter("ID_PUBLICIDAD", $intIdPublicidad);
                $objQueryCount->setParameter("ID_PUBLICIDAD", $intIdPublicidad);
            }
            if(!empty($strDescrPublicidad))
            {
                $strWhere .= " AND lower(PB.DESCRIPCION) like lower(:DESCRIPCION) ";
                $objQuery->setParameter("DESCRIPCION", '%' . trim($strDescrPublicidad) . '%');
                $objQueryCount->setParameter("DESCRIPCION", '%' . trim($strDescrPublicidad) . '%');
            }
            $objRsmBuilder->addScalarResult('ID_PUBLICIDAD', 'ID_PUBLICIDAD', 'string');
            $objRsmBuilder->addScalarResult('IMAGEN', 'IMAGEN', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION', 'DESCRIPCION', 'string');
            $objRsmBuilder->addScalarResult('EDAD_MAXIMA', 'EDAD_MAXIMA', 'string');
            $objRsmBuilder->addScalarResult('EDAD_MINIMA', 'EDAD_MINIMA', 'string');
            $objRsmBuilder->addScalarResult('PAIS', 'PAIS', 'string');
            $objRsmBuilder->addScalarResult('PROVINCIA', 'PROVINCIA', 'string');
            $objRsmBuilder->addScalarResult('CIUDAD', 'CIUDAD', 'string');
            $objRsmBuilder->addScalarResult('CIUDAD_NOMBRE', 'CIUDAD_NOMBRE', 'string');
            $objRsmBuilder->addScalarResult('PARROQUIA', 'PARROQUIA', 'string');
            $objRsmBuilder->addScalarResult('PARROQUIA_NOMBRE', 'PARROQUIA_NOMBRE', 'string');
            $objRsmBuilder->addScalarResult('GENERO', 'GENERO', 'string');
            $objRsmBuilder->addScalarResult('ESTADO', 'ESTADO', 'string');
            $objRsmBuilder->addScalarResult('USR_CREACION', 'USR_CREACION', 'string');
            $objRsmBuilder->addScalarResult('FE_CREACION', 'FE_CREACION', 'date');
            $objRsmBuilder->addScalarResult('USR_MODIFICACION', 'USR_MODIFICACION', 'string');
            $objRsmBuilder->addScalarResult('FE_MODIFICACION', 'FE_MODIFICACION', 'date');
            $objRsmBuilderCount->addScalarResult('CANTIDAD', 'Cantidad', 'integer');
            $strSql       = $strSelect.$strFrom.$strWhere;
            $objQuery->setSQL($strSql);
            $strSqlCount  = $strSelectCount.$strFrom.$strWhere;
            $objQueryCount->setSQL($strSqlCount);
            $arrayPublicidad['cantidad']   = $objQueryCount->getSingleScalarResult();
            $arrayPublicidad['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayPublicidad['error'] = $strMensajeError;
        return $arrayPublicidad;
    }
}
