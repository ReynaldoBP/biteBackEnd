<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * InfoPreguntaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InfoPreguntaRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Documentación para la función 'getPreguntaCriterio'
     * Método encargado de retornar todos las preguntas según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 16-07-2019
     * 
     * @return array  $arrayEncuesta
     * 
     */    
    public function getPreguntaCriterio($arrayParametros)
    {
        $strIdPregunta         = $arrayParametros['strIdPregunta'] ? $arrayParametros['strIdPregunta']:'';
        $strIdEncuesta         = $arrayParametros['strIdEncuesta'] ? $arrayParametros['strIdEncuesta']:'';
        $strDescripcion        = $arrayParametros['strDescripcion'] ? $arrayParametros['strDescripcion']:'';
        $strObligatoria        = $arrayParametros['strObligatoria'] ? $arrayParametros['strObligatoria']:'';
        $strCentroComercial    = $arrayParametros['strCentroComercial'] ? $arrayParametros['strCentroComercial']:'';
        $strEstado             = $arrayParametros['strEstado'] ? $arrayParametros['strEstado']:array('ACTIVO','INACTIVO','ELIMINADO');
        $arrayEncuesta         = array();
        $strMensajeError       = '';
        $objRsmBuilder         = new ResultSetMappingBuilder($this->_em);
        $objQuery              = $this->_em->createNativeQuery(null, $objRsmBuilder);
        $objRsmBuilderCount    = new ResultSetMappingBuilder($this->_em);
        $objQueryCount         = $this->_em->createNativeQuery(null, $objRsmBuilderCount);
        $strOrder              = ' ORDER BY PE.ID_PREGUNTA ASC';
        try
        {
            $strSelect      = "SELECT PE.ID_PREGUNTA,PE.ENCUESTA_ID,PE.DESCRIPCION AS DESCRIPCION_PREGUNTA,PE.OBLIGATORIA,PE.ESTADO AS ESTADO_PREGUNTA, 
                                      EC.ID_ENCUESTA,EC.DESCRIPCION AS DESCRIPCION_ENCUESTA, EC.ESTADO AS ESTADO_ENCUESTA, PE.EN_CENTRO_COMERCIAL,
                                      IOR.ID_OPCION_RESPUESTA,IOR.TIPO_RESPUESTA,IOR.DESCRIPCION AS DESCRIPCION_OPCION_RESPUESTA,IOR.VALOR AS VALOR_OPCION_RESPUESTA, 
                                      IOR.ESTADO AS ESTADO_OPCION_RESPUESTA,
                                      PE.USR_CREACION, PE.FE_CREACION,PE.USR_MODIFICACION,PE.FE_MODIFICACION ";
            $strSelectCount = "SELECT COUNT(*) AS CANTIDAD ";
            $strFrom        = "FROM INFO_ENCUESTA EC, INFO_PREGUNTA PE, INFO_OPCION_RESPUESTA IOR ";
            $strWhere       = "WHERE PE.ESTADO in (:ESTADO) AND PE.ENCUESTA_ID=EC.ID_ENCUESTA AND PE.OPCION_RESPUESTA_ID=IOR.ID_OPCION_RESPUESTA";
            $objQuery->setParameter("ESTADO", $strEstado);
            $objQueryCount->setParameter("ESTADO", $strEstado);
            if(!empty($strIdPregunta))
            {
                $strWhere .= " AND PE.ID_PREGUNTA =:ID_PREGUNTA";
                $objQuery->setParameter("ID_PREGUNTA", $strIdPregunta);
                $objQueryCount->setParameter("ID_PREGUNTA", $strIdPregunta);
            }
            if(!empty($strIdEncuesta))
            {
                $strWhere .= " AND EC.ID_ENCUESTA =:ID_ENCUESTA";
                $objQuery->setParameter("ID_ENCUESTA", $strIdEncuesta);
                $objQueryCount->setParameter("ID_ENCUESTA", $strIdEncuesta);
            }
            if(!empty($strCentroComercial))
            {
                $strWhere .= " AND PE.EN_CENTRO_COMERCIAL =:EN_CENTRO_COMERCIAL";
                $objQuery->setParameter("EN_CENTRO_COMERCIAL", $strCentroComercial);
                $objQueryCount->setParameter("EN_CENTRO_COMERCIAL", $strCentroComercial);
            }
            if(!empty($strDescripcion))
            {
                $strWhere .= " AND lower(PE.DESCRIPCION) like lower(:DESCRIPCION)";
                $objQuery->setParameter("DESCRIPCION", '%' . trim($strDescripcion) . '%');
                $objQueryCount->setParameter("DESCRIPCION", '%' . trim($strDescripcion) . '%');
            }
            if(!empty($strObligatoria))
            {
                $strWhere .= " AND lower(PE.OBLIGATORIA) like lower(:OBLIGATORIA)";
                $objQuery->setParameter("OBLIGATORIA", '%' . trim($strTitulo) . '%');
                $objQueryCount->setParameter("OBLIGATORIA", '%' . trim($strTitulo) . '%');
            }
            $objRsmBuilder->addScalarResult('ID_PREGUNTA', 'ID_PREGUNTA', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_PREGUNTA', 'ESTADO_PREGUNTA', 'string');
            $objRsmBuilder->addScalarResult('ENCUESTA_ID', 'ENCUESTA_ID', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION_PREGUNTA', 'DESCRIPCION_PREGUNTA', 'string');
            $objRsmBuilder->addScalarResult('EN_CENTRO_COMERCIAL', 'EN_CENTRO_COMERCIAL', 'string');
            $objRsmBuilder->addScalarResult('OBLIGATORIA', 'OBLIGATORIA', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_ENCUESTA', 'ESTADO_ENCUESTA', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION_ENCUESTA', 'DESCRIPCION_ENCUESTA', 'string');
            $objRsmBuilder->addScalarResult('ID_OPCION_RESPUESTA', 'ID_OPCION_RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('TIPO_RESPUESTA', 'TIPO_RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION_OPCION_RESPUESTA', 'DESCRIPCION_OPCION_RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('VALOR_OPCION_RESPUESTA', 'VALOR_OPCION_RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_OPCION_RESPUESTA', 'ESTADO_OPCION_RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('USR_CREACION', 'USR_CREACION', 'string');
            $objRsmBuilder->addScalarResult('FE_CREACION', 'FE_CREACION', 'date');
            $objRsmBuilder->addScalarResult('USR_MODIFICACION', 'USR_MODIFICACION', 'string');
            $objRsmBuilder->addScalarResult('FE_MODIFICACION', 'FE_MODIFICACION', 'date');

            $objRsmBuilderCount->addScalarResult('CANTIDAD', 'Cantidad', 'integer');
            $strSql       = $strSelect.$strFrom.$strWhere.$strOrder;
            $objQuery->setSQL($strSql);
            $strSqlCount  = $strSelectCount.$strFrom.$strWhere;
            $objQueryCount->setSQL($strSqlCount);
            $arrayEncuesta['cantidad']   = $objQueryCount->getSingleScalarResult();
            $arrayEncuesta['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayEncuesta['error'] = $strMensajeError;
        return $arrayEncuesta;
    }
    /**
     * Documentación para la función 'getPreguntaCriterioMovil'
     * Método encargado de retornar todos las preguntas según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 02-09-2019
     * 
     * @return array  $arrayEncuesta
     * 
     */    
    public function getPreguntaCriterioMovil($arrayParametros)
    {
        $strIdPregunta         = $arrayParametros['strIdPregunta'] ? $arrayParametros['strIdPregunta']:'';
        $strIdEncuesta         = $arrayParametros['strIdEncuesta'] ? $arrayParametros['strIdEncuesta']:'';
        $strDescripcion        = $arrayParametros['strDescripcion'] ? $arrayParametros['strDescripcion']:'';
        $strCentroComercial    = $arrayParametros['strCentroComercial'] ? $arrayParametros['strCentroComercial']:'';
        $strObligatoria        = $arrayParametros['strObligatoria'] ? $arrayParametros['strObligatoria']:'';
        $strEstado             = $arrayParametros['strEstado'] ? $arrayParametros['strEstado']:array('ACTIVO','INACTIVO','ELIMINADO');
        $arrayEncuesta         = array();
        $strMensajeError       = '';
        $objRsmBuilder         = new ResultSetMappingBuilder($this->_em);
        $objQuery              = $this->_em->createNativeQuery(null, $objRsmBuilder);
        $objRsmBuilderCount    = new ResultSetMappingBuilder($this->_em);
        $objQueryCount         = $this->_em->createNativeQuery(null, $objRsmBuilderCount);
        $strOrder              = ' ORDER BY PE.FE_CREACION ASC';
        try
        {
            $strSelect      = "SELECT PE.ID_PREGUNTA,PE.ENCUESTA_ID,PE.DESCRIPCION AS DESCRIPCION_PREGUNTA,PE.OBLIGATORIA,PE.ESTADO AS ESTADO_PREGUNTA, 
                                      EC.ID_ENCUESTA,EC.DESCRIPCION AS DESCRIPCION_ENCUESTA, EC.ESTADO AS ESTADO_ENCUESTA,PE.EN_CENTRO_COMERCIAL,
                                      IOR.ID_OPCION_RESPUESTA,IOR.TIPO_RESPUESTA,IOR.DESCRIPCION AS DESCRIPCION_OPCION_RESPUESTA,IOR.VALOR AS VALOR_OPCION_RESPUESTA, 
                                      IOR.ESTADO AS ESTADO_OPCION_RESPUESTA,
                                      PE.USR_CREACION, PE.FE_CREACION,PE.USR_MODIFICACION,PE.FE_MODIFICACION ";
            $strSelectCount = "SELECT COUNT(*) AS CANTIDAD ";
            $strFrom        = "FROM INFO_ENCUESTA EC, INFO_PREGUNTA PE, INFO_OPCION_RESPUESTA IOR ";
            $strWhere       = "WHERE PE.ESTADO in (:ESTADO) AND PE.ENCUESTA_ID=EC.ID_ENCUESTA AND PE.OPCION_RESPUESTA_ID=IOR.ID_OPCION_RESPUESTA";
            $objQuery->setParameter("ESTADO", $strEstado);
            $objQueryCount->setParameter("ESTADO", $strEstado);
            if(!empty($strIdPregunta))
            {
                $strWhere .= " AND PE.ID_PREGUNTA =:ID_PREGUNTA";
                $objQuery->setParameter("ID_PREGUNTA", $strIdPregunta);
                $objQueryCount->setParameter("ID_PREGUNTA", $strIdPregunta);
            }
            if(!empty($strIdEncuesta))
            {
                $strWhere .= " AND EC.ID_ENCUESTA =:ID_ENCUESTA";
                $objQuery->setParameter("ID_ENCUESTA", $strIdEncuesta);
                $objQueryCount->setParameter("ID_ENCUESTA", $strIdEncuesta);
            }
            if(!empty($strDescripcion))
            {
                $strWhere .= " AND lower(PE.DESCRIPCION) like lower(:DESCRIPCION)";
                $objQuery->setParameter("DESCRIPCION", '%' . trim($strDescripcion) . '%');
                $objQueryCount->setParameter("DESCRIPCION", '%' . trim($strDescripcion) . '%');
            }
            if(!empty($strCentroComercial))
            {
                $strWhere .= " AND PE.EN_CENTRO_COMERCIAL =:EN_CENTRO_COMERCIAL";
                $objQuery->setParameter("EN_CENTRO_COMERCIAL", $strCentroComercial);
                $objQueryCount->setParameter("EN_CENTRO_COMERCIAL", $strCentroComercial);
            }
            if(!empty($strObligatoria))
            {
                $strWhere .= " AND lower(PE.OBLIGATORIA) like lower(:OBLIGATORIA)";
                $objQuery->setParameter("OBLIGATORIA", '%' . trim($strTitulo) . '%');
                $objQueryCount->setParameter("OBLIGATORIA", '%' . trim($strTitulo) . '%');
            }
            $objRsmBuilder->addScalarResult('ID_PREGUNTA', 'ID_PREGUNTA', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_PREGUNTA', 'ESTADO_PREGUNTA', 'string');
            $objRsmBuilder->addScalarResult('ENCUESTA_ID', 'ENCUESTA_ID', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION_PREGUNTA', 'DESCRIPCION_PREGUNTA', 'string');
            $objRsmBuilder->addScalarResult('EN_CENTRO_COMERCIAL', 'EN_CENTRO_COMERCIAL', 'string');
            $objRsmBuilder->addScalarResult('OBLIGATORIA', 'OBLIGATORIA', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_ENCUESTA', 'ESTADO_ENCUESTA', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION_ENCUESTA', 'DESCRIPCION_ENCUESTA', 'string');
            $objRsmBuilder->addScalarResult('ID_OPCION_RESPUESTA', 'ID_OPCION_RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('TIPO_RESPUESTA', 'TIPO_RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION_OPCION_RESPUESTA', 'DESCRIPCION_OPCION_RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('VALOR_OPCION_RESPUESTA', 'VALOR_OPCION_RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_OPCION_RESPUESTA', 'ESTADO_OPCION_RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('USR_CREACION', 'USR_CREACION', 'string');
            $objRsmBuilder->addScalarResult('FE_CREACION', 'FE_CREACION', 'date');
            $objRsmBuilder->addScalarResult('USR_MODIFICACION', 'USR_MODIFICACION', 'string');
            $objRsmBuilder->addScalarResult('FE_MODIFICACION', 'FE_MODIFICACION', 'date');

            $objRsmBuilderCount->addScalarResult('CANTIDAD', 'Cantidad', 'integer');
            $strSql       = $strSelect.$strFrom.$strWhere.$strOrder;
            $objQuery->setSQL($strSql);
            $strSqlCount  = $strSelectCount.$strFrom.$strWhere;
            $objQueryCount->setSQL($strSqlCount);
            $arrayEncuesta['cantidad']   = $objQueryCount->getSingleScalarResult();
            $arrayEncuesta['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayEncuesta['error'] = $strMensajeError;
        return $arrayEncuesta;
    }
}
