<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
/**
 * InfoRedesSocialesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InfoRedesSocialesRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Documentación para la función 'getRedesSocialMensual'
     * Método encargado de retornar las redes sociales mensual.
     * según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 17-10-2019
     * 
     * @return array  $arrayRedSocial
     * 
     */
    public function getRedesSocialMensual($arrayParametros)
    {
        $strMes             = $arrayParametros['strMes'] ? $arrayParametros['strMes']:'';
        $strAnio            = $arrayParametros['strAnio'] ? $arrayParametros['strAnio']:'';
        $arrayRedSocial     = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        try
        {
            $strSelect      = "SELECT IR.ID_REDES_SOCIALES,
                                      IR.DESCRIPCION,
                                      IFNULL((SELECT count(*) 
                                                FROM INFO_CONTENIDO_SUBIDO
                                                WHERE REDES_SOCIALES_ID = IR.ID_REDES_SOCIALES
                                                AND EXTRACT( MONTH FROM FE_CREACION) = :MES 
                                                AND EXTRACT( YEAR FROM  FE_CREACION) = :ANIO  ),0) AS CANTIDAD ";

            $strFrom        = " FROM INFO_REDES_SOCIALES IR ";
            $objQuery->setParameter("MES",$strMes);
            $objQuery->setParameter("ANIO",$strAnio);

            $objRsmBuilder->addScalarResult('ID_REDES_SOCIALES', 'ID_REDES_SOCIALES', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION', 'DESCRIPCION', 'string');
            $objRsmBuilder->addScalarResult('CANTIDAD', 'CANTIDAD', 'string');
            $strSql       = $strSelect.$strFrom;
            $objQuery->setSQL($strSql);
            $arrayRedSocial['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayRedSocial['error'] = $strMensajeError;
        return $arrayRedSocial;
    }
}
