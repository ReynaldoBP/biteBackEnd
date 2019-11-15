<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * InfoRespuestaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InfoRespuestaRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Documentación para la función 'getRespuestaDashboard'
     * Método encargado de retornar las respuestas de los clientes
     * según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 02-10-2019
     * 
     * @return array  $arrayRespuesta
     * 
     */    
    public function getRespuestaDashboard($arrayParametros)
    {
        $intIdCltEncuesta   = $arrayParametros['intIdCltEncuesta'] ? $arrayParametros['intIdCltEncuesta']:'';
        $strEstado          = $arrayParametros['strEstado'] ? $arrayParametros['strEstado']:array('ACTIVO','INACTIVO','ELIMINADO');
        $strMes             = $arrayParametros['strMes'] ? $arrayParametros['strMes']:'';
        $strAnio            = $arrayParametros['strAnio'] ? $arrayParametros['strAnio']:'';
        $arrayRespuesta     = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        try
        {
            $strSelect      = "SELECT C.DESCRIPCION AS RED_SOCIAL, A.FE_CREACION, A.CLIENTE_ID, 
                                D.TITULO, B.IMAGEN, A.ESTADO, A.ID_CLT_ENCUESTA ";
            $strFrom        = "FROM INFO_CLIENTE_ENCUESTA A 
                                INNER JOIN INFO_CONTENIDO_SUBIDO B 
                                    ON A.CONTENIDO_ID = B.`ID_CONTENIDO_SUBIDO`
                                INNER JOIN INFO_REDES_SOCIALES C 
                                    ON C.ID_REDES_SOCIALES = B.REDES_SOCIALES_ID
                                INNER JOIN INFO_ENCUESTA D 
                                    ON A.ENCUESTA_ID = D.ID_ENCUESTA ";
            $strWhere       = "WHERE A.ESTADO in (:ESTADO)
                                AND EXTRACT(YEAR FROM A.FE_CREACION ) = :strAnio 
                                AND EXTRACT(MONTH FROM A.FE_CREACION ) = :strMes ";
            $objQuery->setParameter("ESTADO",$strEstado);
            $objQuery->setParameter("strMes", $strMes);
            $objQuery->setParameter("strAnio", $strAnio);
            if(!empty($intIdCltEncuesta))
            {
                $strWhere .= " AND A.ID_CLT_ENCUESTA = :ID_CLT_ENCUESTA ";
                $objQuery->setParameter("ID_CLT_ENCUESTA",$intIdCltEncuesta);
            }
            $objRsmBuilder->addScalarResult('RED_SOCIAL', 'RED_SOCIAL', 'string');
            $objRsmBuilder->addScalarResult('FE_CREACION', 'FE_CREACION', 'string');
            $objRsmBuilder->addScalarResult('CLIENTE_ID', 'CLIENTE_ID', 'string');
            $objRsmBuilder->addScalarResult('TITULO', 'TITULO', 'string');
            $objRsmBuilder->addScalarResult('IMAGEN', 'IMAGEN', 'string');
            $objRsmBuilder->addScalarResult('ESTADO', 'ESTADO', 'string');
            $objRsmBuilder->addScalarResult('ID_CLT_ENCUESTA', 'ID_CLT_ENCUESTA', 'string');
            $strSql       = $strSelect.$strFrom.$strWhere;
            $objQuery->setSQL($strSql);
            $arrayRespuesta['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayRespuesta['error'] = $strMensajeError;
        return $arrayRespuesta;
    }
    /**
     * Documentación para la función 'getRespuestaCriterio'
     * Método encargado de retornar las respuestas de los clientes
     * según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 15-09-2019
     * 
     * @return array  $arrayRespuesta
     * 
     */
    public function getRespuestaCriterio($arrayParametros)
    {
        $intIdCltEncuesta   = $arrayParametros['intIdCltEncuesta'] ? $arrayParametros['intIdCltEncuesta']:'';
        $intIdPregunta      = $arrayParametros['intIdPregunta'] ? $arrayParametros['intIdPregunta']:'';
        $strEstado          = $arrayParametros['strEstado'] ? $arrayParametros['strEstado']:array('ACTIVO','INACTIVO','ELIMINADO');
        $arrayRespuesta     = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        $objRsmBuilderCount = new ResultSetMappingBuilder($this->_em);
        $objQueryCount      = $this->_em->createNativeQuery(null, $objRsmBuilderCount);
        try
        {
            $strSelect      = "SELECT IPR.ID_PREGUNTA,IPR.DESCRIPCION AS DESCRIPCION_PREGUNTA,IPR.OBLIGATORIA,IPR.ESTADO AS ESTADO_PREGUNTA,
                                IPR.EN_CENTRO_COMERCIAL,IRE.RESPUESTA,IRE.ESTADO AS ESTADO_RESPUESTA,
                                IOR.TIPO_RESPUESTA,IOR.VALOR ";
            $strSelectCount = "SELECT COUNT(*) AS CANTIDAD ";
            $strFrom        = "FROM INFO_RESPUESTA          IRE
                                JOIN INFO_PREGUNTA          IPR  ON IPR.ID_PREGUNTA=IRE.PREGUNTA_ID
                                JOIN INFO_OPCION_RESPUESTA  IOR  ON IOR.ID_OPCION_RESPUESTA=IPR.OPCION_RESPUESTA_ID ";
            $strWhere       = "WHERE IRE.ESTADO in (:ESTADO) ";
            $objQuery->setParameter("ESTADO",$strEstado);
            $objQueryCount->setParameter("ESTADO",$strEstado);
            if(!empty($intIdCltEncuesta))
            {
                $strWhere .= " AND IRE.CLT_ENCUESTA_ID =:CLT_ENCUESTA_ID";
                $objQuery->setParameter("CLT_ENCUESTA_ID", $intIdCltEncuesta);
                $objQueryCount->setParameter("CLT_ENCUESTA_ID", $intIdCltEncuesta);
            }
            if(!empty($intIdPregunta))
            {
                $strWhere .= " AND IPR.ID_PREGUNTA =:ID_PREGUNTA";
                $objQuery->setParameter("ID_PREGUNTA", $intIdPregunta);
                $objQueryCount->setParameter("ID_PREGUNTA", $intIdPregunta);
            }

            $objRsmBuilder->addScalarResult('ID_PREGUNTA', 'ID_PREGUNTA', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION_PREGUNTA', 'DESCRIPCION_PREGUNTA', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_PREGUNTA', 'ESTADO_PREGUNTA', 'string');
            $objRsmBuilder->addScalarResult('EN_CENTRO_COMERCIAL', 'EN_CENTRO_COMERCIAL', 'string');
            $objRsmBuilder->addScalarResult('TIPO_RESPUESTA', 'TIPO_RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('VALOR', 'VALOR', 'string');
            $objRsmBuilder->addScalarResult('OBLIGATORIA', 'OBLIGATORIA', 'string');
            $objRsmBuilder->addScalarResult('RESPUESTA', 'RESPUESTA', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_RESPUESTA', 'ESTADO_RESPUESTA', 'string');
            $objRsmBuilderCount->addScalarResult('CANTIDAD', 'Cantidad', 'integer');
            $strSql       = $strSelect.$strFrom.$strWhere;
            $objQuery->setSQL($strSql);
            $strSqlCount  = $strSelectCount.$strFrom.$strWhere;
            $objQueryCount->setSQL($strSqlCount);
            $arrayRespuesta['cantidad']   = $objQueryCount->getSingleScalarResult();
            $arrayRespuesta['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayRespuesta['error'] = $strMensajeError;
        return $arrayRespuesta;
    }
    /**
     * Documentación para la función 'getResultadoProEncuesta'
     * Método encargado de retornar el resultado promediado
     * encuesta activa según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 20-10-2019
     * 
     * @return array  $arrayRespuesta
     * 
     */
    public function getResultadoProEncuesta($arrayParametros)
    {
        $strFechaIni        = $arrayParametros['strFechaIni'] ? $arrayParametros['strFechaIni']:'';
        $strFechaFin        = $arrayParametros['strFechaFin'] ? $arrayParametros['strFechaFin']:'';
        $strGenero          = $arrayParametros['strGenero'] ? $arrayParametros['strGenero']:'';
        $strHorario         = $arrayParametros['strHorario'] ? $arrayParametros['strHorario']:'';
        $strEdad            = $arrayParametros['strEdad'] ? $arrayParametros['strEdad']:'';
        $strPais            = $arrayParametros['strPais'] ? $arrayParametros['strPais']:'';
        $strCiudad          = $arrayParametros['strCiudad'] ? $arrayParametros['strCiudad']:'';
        $strProvincia       = $arrayParametros['strProvincia'] ? $arrayParametros['strProvincia']:'';
        $strParroquia       = $arrayParametros['strParroquia'] ? $arrayParametros['strParroquia']:'';
        $arrayRespuesta     = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        try
        {
            $strSelect      = "SELECT IP.ID_PREGUNTA,
                                      IP.DESCRIPCION,
                                      ROUND(AVG(RESPUESTA),2) AS PROMEDIO,
                                      IE.TITULO,
                                      IE.ID_ENCUESTA ";
            $strFrom        = "FROM INFO_RESPUESTA IR
                                INNER JOIN INFO_PREGUNTA IP          ON IR.PREGUNTA_ID          = IP.ID_PREGUNTA
                                INNER JOIN INFO_OPCION_RESPUESTA IOR ON IOR.ID_OPCION_RESPUESTA = IP.OPCION_RESPUESTA_ID
                                INNER JOIN INFO_CLIENTE_ENCUESTA ICE ON ICE.ID_CLT_ENCUESTA     = IR.CLT_ENCUESTA_ID
                                INNER JOIN INFO_ENCUESTA IE          ON IE.ID_ENCUESTA          = ICE.ENCUESTA_ID
                                INNER JOIN ADMI_PARAMETRO AP_HORARIO ON AP_HORARIO.DESCRIPCION  = 'HORARIO'
                                    AND CAST(ICE.FE_CREACION AS TIME) >= CAST(AP_HORARIO.VALOR2 AS TIME)
                                    AND CAST(ICE.FE_CREACION AS TIME) <= CAST(AP_HORARIO.VALOR3 AS TIME)
                                INNER JOIN INFO_CLIENTE IC           ON IC.ID_CLIENTE           = ICE.CLIENTE_ID
                                INNER JOIN ADMI_PARAMETRO AP_EDAD    ON AP_EDAD.DESCRIPCION     = 'EDAD'
                                    AND EXTRACT(YEAR FROM IC.EDAD) >= AP_EDAD.VALOR2
                                    AND EXTRACT(YEAR FROM IC.EDAD) <= AP_EDAD.VALOR3
                                INNER JOIN INFO_SUCURSAL ISU         ON ISU.ID_SUCURSAL         =  ICE.SUCURSAL_ID
                                INNER JOIN INFO_RESTAURANTE IRES     ON IRES.ID_RESTAURANTE     = ISU.RESTAURANTE_ID ";
            $strWhere       = "WHERE IOR.TIPO_RESPUESTA = 'CERRADA'
                                AND IOR.VALOR           = '5'
                                AND IE.ESTADO           = 'ACTIVO'
                                AND ICE.ESTADO          = 'ACTIVO' ";
            $strGroupBy     = " GROUP BY PREGUNTA_ID ";

            if(!empty($strFechaIni) && !empty($strFechaFin))
            {
                $strWhere .= " AND ICE.FE_CREACION BETWEEN '".$strFechaIni."' AND '".$strFechaFin."' ";
            }
            if(!empty($strGenero))
            {
                $strWhere .= " AND IC.GENERO = :GENERO";
                $objQuery->setParameter("GENERO", $strGenero);
            }
            if(!empty($strHorario))
            {
                $strWhere .= " AND AP_HORARIO.VALOR1 = :HORARIO ";
                $objQuery->setParameter("HORARIO", $strHorario);
            }
            if(!empty($strEdad))
            {
                $strWhere .= " AND AP_EDAD.VALOR1 = :EDAD ";
                $objQuery->setParameter("EDAD", $strEdad);
            }
            if(!empty($strPais))
            {
                $strWhere .= " AND ISU.PAIS = :PAIS ";
                $objQuery->setParameter("PAIS", $strPais);
            }
            if(!empty($strCiudad))
            {
                $strWhere .= " AND ISU.CIUDAD = :CIUDAD ";
                $objQuery->setParameter("CIUDAD", $strCiudad);
            }
            if(!empty($strProvincia))
            {
                $strWhere .= " AND ISU.PROVINCIA = :PROVINCIA ";
                $objQuery->setParameter("PROVINCIA", $strProvincia);
            }
            if(!empty($strParroquia))
            {
                $strWhere .= " AND ISU.PARROQUIA = :PARROQUIA ";
                $objQuery->setParameter("PARROQUIA", $strParroquia);
            }
            $objRsmBuilder->addScalarResult('ID_PREGUNTA', 'ID_PREGUNTA', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION', 'DESCRIPCION', 'string');
            $objRsmBuilder->addScalarResult('PROMEDIO', 'PROMEDIO', 'string');
            $objRsmBuilder->addScalarResult('TITULO', 'TITULO', 'string');
            $objRsmBuilder->addScalarResult('ID_ENCUESTA', 'ID_ENCUESTA', 'string');
            $strSql       = $strSelect.$strFrom.$strWhere.$strGroupBy;
            $objQuery->setSQL($strSql);
            $arrayRespuesta['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayRespuesta['error'] = $strMensajeError;
        return $arrayRespuesta;
    }
    /**
     * Documentación para la función 'getResultadoProPregunta'
     * Método encargado de retornar el resultado promediado
     * preguntas activa según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 07-11-2019
     * 
     * @return array  $arrayRespuesta
     * 
     */
    public function getResultadoProPregunta($arrayParametros)
    {
        $intIdPregunta      = $arrayParametros['intIdPregunta'] ? $arrayParametros['intIdPregunta']:'';
        $intLimite          = $arrayParametros['intLimite'] ? $arrayParametros['intLimite']:1;
        $strGenero          = $arrayParametros['strGenero'] ? $arrayParametros['strGenero']:'';
        $strHorario         = $arrayParametros['strHorario'] ? $arrayParametros['strHorario']:'';
        $strEdad            = $arrayParametros['strEdad'] ? $arrayParametros['strEdad']:'';
        $strPais            = $arrayParametros['strPais'] ? $arrayParametros['strPais']:'';
        $strCiudad          = $arrayParametros['strCiudad'] ? $arrayParametros['strCiudad']:'';
        $strProvincia       = $arrayParametros['strProvincia'] ? $arrayParametros['strProvincia']:'';
        $strParroquia       = $arrayParametros['strParroquia'] ? $arrayParametros['strParroquia']:'';
        $arrayRespuesta     = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        try
        {
            $strSelect      = "SELECT 
                                    EXTRACT(YEAR FROM ICE.FE_CREACION ) AS ANIO, 
                                    EXTRACT(MONTH FROM ICE.FE_CREACION ) AS MES,
                                    ROUND(AVG(RESPUESTA),2) AS PROMEDIO ";
            $strFrom        = "FROM INFO_RESPUESTA IR
                                    INNER JOIN INFO_PREGUNTA IP          ON IR.PREGUNTA_ID          = IP.ID_PREGUNTA
                                    INNER JOIN INFO_OPCION_RESPUESTA IOR ON IOR.ID_OPCION_RESPUESTA = IP.OPCION_RESPUESTA_ID
                                    INNER JOIN INFO_CLIENTE_ENCUESTA ICE ON ICE.ID_CLT_ENCUESTA     = IR.CLT_ENCUESTA_ID
                                    INNER JOIN INFO_ENCUESTA IE          ON IE.ID_ENCUESTA          = ICE.ENCUESTA_ID
                                    INNER JOIN ADMI_PARAMETRO AP_HORARIO ON AP_HORARIO.DESCRIPCION  = 'HORARIO'
                                        AND CAST(ICE.FE_CREACION AS TIME) >= CAST(AP_HORARIO.VALOR2 AS TIME)
                                        AND CAST(ICE.FE_CREACION AS TIME) <= CAST(AP_HORARIO.VALOR3 AS TIME)
                                    INNER JOIN INFO_CLIENTE IC           ON IC.ID_CLIENTE           = ICE.CLIENTE_ID
                                    INNER JOIN ADMI_PARAMETRO AP_EDAD    ON AP_EDAD.DESCRIPCION     = 'EDAD'
                                        AND EXTRACT(YEAR FROM IC.EDAD) >= AP_EDAD.VALOR2
                                        AND EXTRACT(YEAR FROM IC.EDAD) <= AP_EDAD.VALOR3
                                        INNER JOIN INFO_SUCURSAL ISU     ON ISU.ID_SUCURSAL      =  ICE.SUCURSAL_ID
                                        INNER JOIN INFO_RESTAURANTE IRES ON IRES.ID_RESTAURANTE     = ISU.RESTAURANTE_ID ";
            $strWhere       = "WHERE IOR.TIPO_RESPUESTA = 'CERRADA'
                                        AND IOR.VALOR           = '5'
                                        AND IE.ESTADO           = 'ACTIVO'
                                        AND ICE.ESTADO          = 'ACTIVO' ";
            $strGroupBy     = " GROUP BY MES,ANIO ";

            if(!empty($strGenero))
            {
                $strWhere .= " AND IC.GENERO = :GENERO ";
                $objQuery->setParameter("GENERO", $strGenero);
            }
            if(!empty($strHorario))
            {
                $strWhere .= " AND AP_HORARIO.VALOR1 = :HORARIO ";
                $objQuery->setParameter("HORARIO", $strHorario);
            }
            if(!empty($strEdad))
            {
                $strWhere .= " AND AP_EDAD.VALOR1 = :EDAD ";
                $objQuery->setParameter("EDAD", $strEdad);
            }
            if(!empty($strPais))
            {
                $strWhere .= " AND ISU.PAIS = :PAIS ";
                $objQuery->setParameter("PAIS", $strPais);
            }
            if(!empty($strCiudad))
            {
                $strWhere .= " AND ISU.CIUDAD = :CIUDAD ";
                $objQuery->setParameter("CIUDAD", $strCiudad);
            }
            if(!empty($strProvincia))
            {
                $strWhere .= " AND ISU.PROVINCIA = :PROVINCIA ";
                $objQuery->setParameter("PROVINCIA", $strProvincia);
            }
            if(!empty($strParroquia))
            {
                $strWhere .= " AND ISU.PARROQUIA = :PARROQUIA ";
                $objQuery->setParameter("PARROQUIA", $strParroquia);
            }
            if(!empty($intIdPregunta))
            {
                $strWhere .= " AND IP.ID_PREGUNTA = :ID_PREGUNTA ";
                $objQuery->setParameter("ID_PREGUNTA", $intIdPregunta);
            }
            $objRsmBuilder->addScalarResult('ANIO', 'ANIO', 'string');
            $objRsmBuilder->addScalarResult('MES', 'MES', 'string');
            $objRsmBuilder->addScalarResult('PROMEDIO', 'PROMEDIO', 'string');
            $strLimit     =" limit ".$intLimite;
            $strOrder     = " ORDER BY ICE.FE_CREACION DESC ";
            $strSql       = $strSelect.$strFrom.$strWhere.$strGroupBy.$strOrder.$strLimit;
            $objQuery->setSQL($strSql);
            $arrayRespuesta['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayRespuesta['error'] = $strMensajeError;
        return $arrayRespuesta;
    }
    /**
     * Documentación para la función 'getResultadoProPublicaciones'
     * Método encargado de retornar el resultado promediado
     * preguntas activa según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 07-11-2019
     * 
     * @return array  $arrayRespuesta
     * 
     */
    public function getResultadoProPublicaciones($arrayParametros)
    {
        $intLimite          = $arrayParametros['intLimite'] ? $arrayParametros['intLimite']:1;
        $strGenero          = $arrayParametros['strGenero'] ? $arrayParametros['strGenero']:'';
        $strHorario         = $arrayParametros['strHorario'] ? $arrayParametros['strHorario']:'';
        $strEdad            = $arrayParametros['strEdad'] ? $arrayParametros['strEdad']:'';
        $strPais            = $arrayParametros['strPais'] ? $arrayParametros['strPais']:'';
        $strCiudad          = $arrayParametros['strCiudad'] ? $arrayParametros['strCiudad']:'';
        $strProvincia       = $arrayParametros['strProvincia'] ? $arrayParametros['strProvincia']:'';
        $strParroquia       = $arrayParametros['strParroquia'] ? $arrayParametros['strParroquia']:'';
        $arrayRespuesta     = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        try
        {
            $strSelect      = "SELECT EXTRACT(YEAR FROM ICS.FE_CREACION ) ANIO,
                                EXTRACT(MONTH FROM ICS.FE_CREACION )      MES,
                                COUNT(CASE WHEN IR.DESCRIPCION = 'FACEBOOK' THEN ICS.REDES_SOCIALES_ID END) CANT_FACEBOOK,
                                COUNT(CASE WHEN IR.DESCRIPCION = 'TWITTER' THEN ICS.REDES_SOCIALES_ID  END) CANT_TWITTER,
                                COUNT(CASE WHEN IR.DESCRIPCION = 'INSTAGRAM' THEN ICS.REDES_SOCIALES_ID  END) CANT_INSTAGRAM ";
            $strFrom        = "FROM INFO_CONTENIDO_SUBIDO ICS 
                                    INNER JOIN INFO_REDES_SOCIALES IR ON ICS.REDES_SOCIALES_ID = IR.ID_REDES_SOCIALES
                                    INNER JOIN INFO_CLIENTE_ENCUESTA ICE ON ICE.CONTENIDO_ID = ICS.ID_CONTENIDO_SUBIDO
                                    INNER JOIN INFO_ENCUESTA IE          ON IE.ID_ENCUESTA          = ICE.ENCUESTA_ID
                                    INNER JOIN ADMI_PARAMETRO AP_HORARIO ON AP_HORARIO.DESCRIPCION  = 'HORARIO'
                                        AND CAST(ICE.FE_CREACION AS TIME) >= CAST(AP_HORARIO.VALOR2 AS TIME)
                                        AND CAST(ICE.FE_CREACION AS TIME) <= CAST(AP_HORARIO.VALOR3 AS TIME)
                                    INNER JOIN INFO_CLIENTE IC           ON IC.ID_CLIENTE           = ICE.CLIENTE_ID
                                    INNER JOIN ADMI_PARAMETRO AP_EDAD    ON AP_EDAD.DESCRIPCION     = 'EDAD'
                                        AND EXTRACT(YEAR FROM IC.EDAD) >= AP_EDAD.VALOR2
                                        AND EXTRACT(YEAR FROM IC.EDAD) <= AP_EDAD.VALOR3
                                    INNER JOIN INFO_SUCURSAL ISU         ON ISU.ID_SUCURSAL      =  ICE.SUCURSAL_ID
                                    INNER JOIN INFO_RESTAURANTE IRES     ON IRES.ID_RESTAURANTE     = ISU.RESTAURANTE_ID ";
            $strWhere       = "WHERE IR.DESCRIPCION != 'NO COMPARTIDO'
                                    AND ICE.ESTADO   = 'ACTIVO' ";
            $strGroupBy     = " GROUP BY ANIO,MES ";

            if(!empty($strGenero))
            {
                $strWhere .= " AND IC.GENERO = :GENERO";
                $objQuery->setParameter("GENERO", $strGenero);
            }
            if(!empty($strHorario))
            {
                $strWhere .= " AND AP_HORARIO.VALOR1 = :HORARIO ";
                $objQuery->setParameter("HORARIO", $strHorario);
            }
            if(!empty($strEdad))
            {
                $strWhere .= " AND AP_EDAD.VALOR1 = :EDAD ";
                $objQuery->setParameter("EDAD", $strEdad);
            }
            if(!empty($strPais))
            {
                $strWhere .= " AND ISU.PAIS = :PAIS ";
                $objQuery->setParameter("PAIS", $strPais);
            }
            if(!empty($strCiudad))
            {
                $strWhere .= " AND ISU.CIUDAD = :CIUDAD ";
                $objQuery->setParameter("CIUDAD", $strCiudad);
            }
            if(!empty($strProvincia))
            {
                $strWhere .= " AND ISU.PROVINCIA = :PROVINCIA ";
                $objQuery->setParameter("PROVINCIA", $strProvincia);
            }
            if(!empty($strParroquia))
            {
                $strWhere .= " AND ISU.PARROQUIA = :PARROQUIA ";
                $objQuery->setParameter("PARROQUIA", $strParroquia);
            }
            $objRsmBuilder->addScalarResult('ANIO', 'ANIO', 'string');
            $objRsmBuilder->addScalarResult('MES', 'MES', 'string');
            $objRsmBuilder->addScalarResult('CANT_FACEBOOK', 'CANT_FACEBOOK', 'string');
            $objRsmBuilder->addScalarResult('CANT_TWITTER', 'CANT_TWITTER', 'string');
            $objRsmBuilder->addScalarResult('CANT_INSTAGRAM', 'CANT_INSTAGRAM', 'string');
            $strLimit     =" limit ".$intLimite;
            $strOrderBy   = " ORDER BY ICE.FE_CREACION DESC ";
            $strSql       = $strSelect.$strFrom.$strWhere.$strGroupBy.$strOrderBy.$strLimit;
            $objQuery->setSQL($strSql);
            $arrayRespuesta['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayRespuesta['error'] = $strMensajeError;
        return $arrayRespuesta;
    }
    /**
     * Documentación para la función 'getResultadosProIPN'
     * Método encargado de retornar el resultado promediado
     * IPN activa según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 08-11-2019
     * 
     * @return array  $arrayRespuesta
     * 
     */
    public function getResultadosProIPN($arrayParametros)
    {
        $strFechaIni        = $arrayParametros['strFechaIni'] ? $arrayParametros['strFechaIni']:'';
        $strFechaFin        = $arrayParametros['strFechaFin'] ? $arrayParametros['strFechaFin']:'';
        $strGenero          = $arrayParametros['strGenero'] ? $arrayParametros['strGenero']:'';
        $strHorario         = $arrayParametros['strHorario'] ? $arrayParametros['strHorario']:'';
        $strEdad            = $arrayParametros['strEdad'] ? $arrayParametros['strEdad']:'';
        $strPais            = $arrayParametros['strPais'] ? $arrayParametros['strPais']:'';
        $strCiudad          = $arrayParametros['strCiudad'] ? $arrayParametros['strCiudad']:'';
        $strProvincia       = $arrayParametros['strProvincia'] ? $arrayParametros['strProvincia']:'';
        $strParroquia       = $arrayParametros['strParroquia'] ? $arrayParametros['strParroquia']:'';
        $arrayRespuesta     = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        try
        {
            $strSelect      = "SELECT   IE.TITULO,
                                        IE.ID_ENCUESTA ,
                                        IP.ID_PREGUNTA,
                                        IP.DESCRIPCION,
                                        COUNT(CASE WHEN RESPUESTA = 1 THEN RESPUESTA END) CANT_1,
                                        COUNT(CASE WHEN RESPUESTA = 2 THEN RESPUESTA END) CANT_2,
                                        COUNT(CASE WHEN RESPUESTA = 3 THEN RESPUESTA END) CANT_3,
                                        COUNT(CASE WHEN RESPUESTA = 4 THEN RESPUESTA END) CANT_4,
                                        COUNT(CASE WHEN RESPUESTA = 5 THEN RESPUESTA END) CANT_5,
                                        COUNT(CASE WHEN RESPUESTA = 6 THEN RESPUESTA END) CANT_6,
                                        COUNT(CASE WHEN RESPUESTA = 7 THEN RESPUESTA END) CANT_7,
                                        COUNT(CASE WHEN RESPUESTA = 8 THEN RESPUESTA END) CANT_8,
                                        COUNT(CASE WHEN RESPUESTA = 9 THEN RESPUESTA END) CANT_9,
                                        COUNT(CASE WHEN RESPUESTA = 10 THEN RESPUESTA END) CANT_10 ";
            $strFrom        = "FROM INFO_RESPUESTA IR
                                    INNER JOIN INFO_PREGUNTA IP          ON IR.PREGUNTA_ID          = IP.ID_PREGUNTA
                                    INNER JOIN INFO_OPCION_RESPUESTA IOR ON IOR.ID_OPCION_RESPUESTA = IP.OPCION_RESPUESTA_ID
                                    INNER JOIN INFO_CLIENTE_ENCUESTA ICE ON ICE.ID_CLT_ENCUESTA     = IR.CLT_ENCUESTA_ID
                                    INNER JOIN INFO_ENCUESTA IE          ON IE.ID_ENCUESTA          = ICE.ENCUESTA_ID
                                    INNER JOIN ADMI_PARAMETRO AP_HORARIO ON AP_HORARIO.DESCRIPCION  = 'HORARIO'
                                        AND CAST(ICE.FE_CREACION AS TIME) >= CAST(AP_HORARIO.VALOR2 AS TIME)
                                        AND CAST(ICE.FE_CREACION AS TIME) <= CAST(AP_HORARIO.VALOR3 AS TIME)
                                    INNER JOIN INFO_CLIENTE IC           ON IC.ID_CLIENTE           = ICE.CLIENTE_ID
                                    INNER JOIN ADMI_PARAMETRO AP_EDAD    ON AP_EDAD.DESCRIPCION     = 'EDAD'
                                        AND EXTRACT(YEAR FROM IC.EDAD) >= AP_EDAD.VALOR2
                                        AND EXTRACT(YEAR FROM IC.EDAD) <= AP_EDAD.VALOR3
                                    INNER JOIN INFO_SUCURSAL ISU         ON ISU.ID_SUCURSAL         =  ICE.SUCURSAL_ID
                                    INNER JOIN INFO_RESTAURANTE IRES     ON IRES.ID_RESTAURANTE     = ISU.RESTAURANTE_ID ";
            $strWhere       = "WHERE IOR.TIPO_RESPUESTA = 'CERRADA'
                                AND IOR.VALOR           = '10'
                                AND IE.ESTADO           = 'ACTIVO'
                                AND ICE.ESTADO          = 'ACTIVO' ";

            if(!empty($strFechaIni) && !empty($strFechaFin))
            {
                $strWhere .= " AND ICE.FE_CREACION BETWEEN '".$strFechaIni."' AND '".$strFechaFin."' ";
            }
            if(!empty($strGenero))
            {
                $strWhere .= " AND IC.GENERO = :GENERO";
                $objQuery->setParameter("GENERO", $strGenero);
            }
            if(!empty($strHorario))
            {
                $strWhere .= " AND AP_HORARIO.VALOR1 = :HORARIO ";
                $objQuery->setParameter("HORARIO", $strHorario);
            }
            if(!empty($strEdad))
            {
                $strWhere .= " AND AP_EDAD.VALOR1 = :EDAD ";
                $objQuery->setParameter("EDAD", $strEdad);
            }
            if(!empty($strPais))
            {
                $strWhere .= " AND ISU.PAIS = :PAIS ";
                $objQuery->setParameter("PAIS", $strPais);
            }
            if(!empty($strCiudad))
            {
                $strWhere .= " AND ISU.CIUDAD = :CIUDAD ";
                $objQuery->setParameter("CIUDAD", $strCiudad);
            }
            if(!empty($strProvincia))
            {
                $strWhere .= " AND ISU.PROVINCIA = :PROVINCIA ";
                $objQuery->setParameter("PROVINCIA", $strProvincia);
            }
            if(!empty($strParroquia))
            {
                $strWhere .= " AND ISU.PARROQUIA = :PARROQUIA ";
                $objQuery->setParameter("PARROQUIA", $strParroquia);
            }
            $objRsmBuilder->addScalarResult('TITULO', 'TITULO', 'string');
            $objRsmBuilder->addScalarResult('ID_ENCUESTA', 'ID_ENCUESTA', 'string');
            $objRsmBuilder->addScalarResult('ID_PREGUNTA', 'ID_PREGUNTA', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION', 'DESCRIPCION', 'string');
            $objRsmBuilder->addScalarResult('CANT_1', 'CANT_1', 'string');
            $objRsmBuilder->addScalarResult('CANT_2', 'CANT_2', 'string');
            $objRsmBuilder->addScalarResult('CANT_3', 'CANT_3', 'string');
            $objRsmBuilder->addScalarResult('CANT_4', 'CANT_4', 'string');
            $objRsmBuilder->addScalarResult('CANT_5', 'CANT_5', 'string');
            $objRsmBuilder->addScalarResult('CANT_6', 'CANT_6', 'string');
            $objRsmBuilder->addScalarResult('CANT_7', 'CANT_7', 'string');
            $objRsmBuilder->addScalarResult('CANT_8', 'CANT_8', 'string');
            $objRsmBuilder->addScalarResult('CANT_9', 'CANT_9', 'string');
            $objRsmBuilder->addScalarResult('CANT_10', 'CANT_10', 'string');
            $strSql       = $strSelect.$strFrom.$strWhere;
            $objQuery->setSQL($strSql);
            $arrayRespuesta['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayRespuesta['error'] = $strMensajeError;
        return $arrayRespuesta;
    }
}
