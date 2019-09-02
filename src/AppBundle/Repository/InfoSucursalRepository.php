<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
/**
 * InfoSucursalRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InfoSucursalRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Documentación para la función 'getSucursalCriterio'
     * Método encargado de retornar todos las sucursales según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 16-07-2019
     * 
     * @return array  $arraySucursal
     * 
     */
    public function getSucursalCriterio($arrayParametros)
    {
        $strIdRestaurante      = $arrayParametros['strIdRestaurante'] ? $arrayParametros['strIdRestaurante']:'';
        $strIdentificacionRes  = $arrayParametros['strIdentificacionRes'] ? $arrayParametros['strIdentificacionRes']:'';
        $strEsMatriz           = $arrayParametros['strEsMatriz'] ? $arrayParametros['strEsMatriz']:'';
        $strPais               = $arrayParametros['strPais'] ? $arrayParametros['strPais']:'';
        $strProvincia          = $arrayParametros['strProvincia'] ? $arrayParametros['strProvincia']:'';
        $strCiudad             = $arrayParametros['strCiudad'] ? $arrayParametros['strCiudad']:'';
        $strParroquia          = $arrayParametros['strParroquia'] ? $arrayParametros['strParroquia']:'';
        $strEstado             = $arrayParametros['strEstado'] ? $arrayParametros['strEstado']:array('ACTIVO','INACTIVO','ELIMINADO');
        $strEstadoFacturacion  = $arrayParametros['strEstadoFacturacion'] ? $arrayParametros['strEstadoFacturacion']:'';
        $arraySucursal         = array();
        $strMensajeError       = '';
        $objRsmBuilder         = new ResultSetMappingBuilder($this->_em);
        $objQuery              = $this->_em->createNativeQuery(null, $objRsmBuilder);
        $objRsmBuilderCount    = new ResultSetMappingBuilder($this->_em);
        $objQueryCount         = $this->_em->createNativeQuery(null, $objRsmBuilderCount);
        try
        {
            $strSelect      = "SELECT ISUR.ID_SUCURSAL,ISUR.DESCRIPCION,ISUR.ES_MATRIZ,ISUR.DIRECCION,ISUR.NUMERO_CONTACTO,
                                      IR.IDENTIFICACION,IR.RAZON_SOCIAL, ISUR.RESTAURANTE_ID,ISUR.ESTADO_FACTURACION,ISUR.ESTADO,ISUR.LATITUD,
                                      ISUR.LONGITUD, ISUR.PAIS,ISUR.PROVINCIA,ISUR.CIUDAD,ISUR.PARROQUIA,
                                      ISUR.USR_CREACION, ISUR.FE_CREACION,ISUR.USR_MODIFICACION,ISUR.FE_MODIFICACION ";
            $strSelectCount = "SELECT COUNT(*) AS CANTIDAD ";
            $strFrom        = "FROM INFO_SUCURSAL ISUR, INFO_RESTAURANTE IR ";
            $strWhere       = "WHERE ISUR.ESTADO in (:ESTADO) AND ISUR.RESTAURANTE_ID=IR.ID_RESTAURANTE ";
            $objQuery->setParameter("ESTADO", $strEstado);
            $objQueryCount->setParameter("ESTADO", $strEstado);
            if(!empty($strEsMatriz))
            {
                $strWhere .= " AND ISUR.ES_MATRIZ =:ES_MATRIZ";
                $objQuery->setParameter("ES_MATRIZ", $strEsMatriz);
                $objQueryCount->setParameter("ES_MATRIZ", $strEsMatriz);
            }
            if(!empty($strIdentificacionRes) || !empty($strIdRestaurante))
            {
                $strSelect .= " ,IR.RAZON_SOCIAL ";
                $strFrom   .= " ,INFO_RESTAURANTE IR ";
                $strWhere  .= " AND IR.ID_RESTAURANTE=ISUR.RESTAURANTE_ID ";
                if(!empty($strIdentificacionRes))
                {
                    $strWhere .= " AND IR.IDENTIFICACION = :IDENTIFICACION";
                    $objQuery->setParameter("IDENTIFICACION", $strIdentificacionRes);
                    $objQueryCount->setParameter("IDENTIFICACION", $strIdentificacionRes);
                }
                if(!empty($strIdRestaurante))
                {
                    $strWhere .= " AND IR.ID_RESTAURANTE = :ID_RESTAURANTE";
                    $objQuery->setParameter("ID_RESTAURANTE", $strIdRestaurante);
                    $objQueryCount->setParameter("ID_RESTAURANTE", $strIdRestaurante);
                }
                $objQueryCount->setParameter("IDENTIFICACION", $strIdentificacionRes);
                $objRsmBuilder->addScalarResult('IDENTIFICACION', 'IDENTIFICACION', 'string');
                $objRsmBuilder->addScalarResult('RAZON_SOCIAL', 'RAZON_SOCIAL', 'string');
            }
            $objRsmBuilder->addScalarResult('ID_SUCURSAL', 'ID_SUCURSAL', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION', 'DESCRIPCION', 'string');
            $objRsmBuilder->addScalarResult('ES_MATRIZ', 'ES_MATRIZ', 'string');
            $objRsmBuilder->addScalarResult('DIRECCION', 'DIRECCION', 'string');
            $objRsmBuilder->addScalarResult('RESTAURANTE_ID', 'RESTAURANTE_ID', 'string');
            $objRsmBuilder->addScalarResult('IDENTIFICACION', 'IDENTIFICACION', 'string');
            $objRsmBuilder->addScalarResult('RAZON_SOCIAL', 'RAZON_SOCIAL', 'string');
            $objRsmBuilder->addScalarResult('NUMERO_CONTACTO', 'NUMERO_CONTACTO', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_FACTURACION', 'ESTADO_FACTURACION', 'string');
            $objRsmBuilder->addScalarResult('ESTADO', 'ESTADO', 'string');
            $objRsmBuilder->addScalarResult('LATITUD', 'LATITUD', 'string');
            $objRsmBuilder->addScalarResult('LONGITUD', 'LONGITUD', 'string');
            $objRsmBuilder->addScalarResult('PAIS', 'PAIS', 'string');
            $objRsmBuilder->addScalarResult('PROVINCIA', 'PROVINCIA', 'string');
            $objRsmBuilder->addScalarResult('CIUDAD', 'CIUDAD', 'string');
            $objRsmBuilder->addScalarResult('PARROQUIA', 'PARROQUIA', 'string');
            $objRsmBuilder->addScalarResult('USR_CREACION', 'USR_CREACION', 'string');
            $objRsmBuilder->addScalarResult('FE_CREACION', 'FE_CREACION', 'date');
            $objRsmBuilder->addScalarResult('USR_MODIFICACION', 'USR_MODIFICACION', 'string');
            $objRsmBuilder->addScalarResult('FE_MODIFICACION', 'FE_MODIFICACION', 'date');

            $objRsmBuilderCount->addScalarResult('CANTIDAD', 'Cantidad', 'integer');
            $strSql       = $strSelect.$strFrom.$strWhere;
            $objQuery->setSQL($strSql);
            $strSqlCount  = $strSelectCount.$strFrom.$strWhere;
            $objQueryCount->setSQL($strSqlCount);
            $arraySucursal['cantidad']   = $objQueryCount->getSingleScalarResult();
            $arraySucursal['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arraySucursal['error'] = $strMensajeError;
        return $arraySucursal;
    }

    /**
     * Documentación para la función 'getSucursalPorUbicacion'
     * Método encargado de retornar todos las sucursales según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 29-08-2019
     * 
     * @return array  $arraySucursal
     * 
     */
    public function getSucursalPorUbicacion($arrayParametros)
    {
        $strLatitud            = $arrayParametros['latitud'] ? $arrayParametros['latitud']:'';
        $strLongitud           = $arrayParametros['longitud'] ? $arrayParametros['longitud']:'';
        $strMetros             = $arrayParametros['metros'] ? $arrayParametros['metros']:5;
        $strEstado             = $arrayParametros['estado'] ? $arrayParametros['estado']:array('ACTIVO','INACTIVO','ELIMINADO');
        $arraySucursal         = array();
        $strMensajeError       = '';
        $objRsmBuilder         = new ResultSetMappingBuilder($this->_em);
        $objQuery              = $this->_em->createNativeQuery(null, $objRsmBuilder);
        $objRsmBuilderCount    = new ResultSetMappingBuilder($this->_em);
        try
        {
            $strSelect      = "SELECT T1.ID_SUCURSAL, T1.RESTAURANTE_ID, T1.DESCRIPCION, T1.PAIS, T1.PROVINCIA,
                                T1.CIUDAD,T1.PARROQUIA, T1.NOMBRE_COMERCIAL,T1.DISTANCIA  ";
            $strFrom        ="FROM
                                    (SELECT ISU.ID_SUCURSAL, ISU.RESTAURANTE_ID,
                                        ISU.DESCRIPCION, ISU.PAIS,ISU.PROVINCIA,ISU.CIUDAD,ISU.PARROQUIA,
                                        IRE.NOMBRE_COMERCIAL,
                                        (6371 * ACOS( 
                                                    SIN(RADIANS(ISU.LATITUD)) * SIN(RADIANS(:LATITUD)) 
                                                    + COS(RADIANS(ISU.LONGITUD - :LONGITUD)) * COS(RADIANS(ISU.LATITUD)) 
                                                    * COS(RADIANS(:LATITUD))
                                                    )
                                        ) AS DISTANCIA
                                FROM INFO_SUCURSAL ISU
                                INNER JOIN INFO_RESTAURANTE IRE ON IRE.ID_RESTAURANTE = ISU.RESTAURANTE_ID
                                WHERE ISU.ESTADO in (:ESTADO)
                                ) T1 ";
            $strWhere       = "WHERE T1.DISTANCIA < (:METROS/1000) ORDER BY T1.DISTANCIA ASC ";
            $objQuery->setParameter("ESTADO", $strEstado);
            $objQuery->setParameter("LATITUD", $strLatitud);
            $objQuery->setParameter("LONGITUD", $strLongitud);
            $objQuery->setParameter("METROS", $strMetros);

            $objRsmBuilder->addScalarResult('ID_SUCURSAL', 'ID_SUCURSAL', 'string');
            $objRsmBuilder->addScalarResult('RESTAURANTE_ID', 'RESTAURANTE_ID', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION', 'DESCRIPCION', 'string');
            $objRsmBuilder->addScalarResult('PAIS', 'PAIS', 'string');
            $objRsmBuilder->addScalarResult('PROVINCIA', 'PROVINCIA', 'string');
            $objRsmBuilder->addScalarResult('CIUDAD', 'CIUDAD', 'string');
            $objRsmBuilder->addScalarResult('PARROQUIA', 'PARROQUIA', 'string');
            $objRsmBuilder->addScalarResult('NOMBRE_COMERCIAL', 'NOMBRE_COMERCIAL', 'string');
            $objRsmBuilder->addScalarResult('DISTANCIA', 'DISTANCIA', 'string');

            $strSql       = $strSelect.$strFrom.$strFromAd.$strWhere;
            $objQuery->setSQL($strSql);
            $arraySucursal['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arraySucursal['error'] = $strMensajeError;
        return $arraySucursal;
    }
}
