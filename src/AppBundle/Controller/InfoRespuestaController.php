<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoRespuesta;
use AppBundle\Controller\DefaultController;

class InfoRespuestaController extends Controller
{
    /**
     * @Route("/getRespuesta")
     *
     * Documentación para la función 'getRespuesta'
     * Método encargado de retornar las respuestas de los clientes
     * según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 15-09-2019
     * 
     * @return array  $objResponse
     */
    public function getRespuestaAction(Request $request)
    {
        $intIdCltEncuesta       = $request->query->get("idCltEncuesta") ? $request->query->get("idCltEncuesta"):'';
        $intIdPregunta          = $request->query->get("idPregunta") ? $request->query->get("idPregunta"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $arrayRespuesta         = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        try
        {
            $arrayParametros = array('intIdPregunta' => $intIdPregunta,
                                     'intIdCltEncuesta'=>$intIdCltEncuesta,
                                     'strEstado'     => $strEstado);
            $arrayRespuesta = $this->getDoctrine()->getRepository('AppBundle:InfoRespuesta')->getRespuestaCriterio($arrayParametros);
            if(isset($arrayRespuesta['error']) && !empty($arrayRespuesta['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayRespuesta['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayRespuesta['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayRespuesta,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * @Route("/getRespuestaDashboard")
     *
     * Documentación para la función 'getRespuestaDashboard'
     * Método encargado de retornar las respuestas de los clientes
     * según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 15-09-2019
     * 
     * @return array  $objResponse
     */
    public function getRespuestaDashboardAction(Request $request)
    {
        $strAnio                = $request->query->get("strAnio") ? $request->query->get("strAnio"):'';
        $intIdCltEncuesta       = $request->query->get("intIdCltEncuesta") ? $request->query->get("intIdCltEncuesta"):'';
        $strMes                 = $request->query->get("strMes") ? $request->query->get("strMes"):'';
        $conImagen              = $request->query->get("conImagen") ? $request->query->get("conImagen"):'NO';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $arrayRespuesta         = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $objController          = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            $arrayParametros = array('strAnio'   => $strAnio,
                                     'strMes'    => $strMes,
                                     'intIdCltEncuesta' => $intIdCltEncuesta,
                                     'strEstado' => $strEstado);
            $arrayRespuesta = (array) $this->getDoctrine()->getRepository('AppBundle:InfoRespuesta')->getRespuestaDashboard($arrayParametros);
            if(isset($arrayRespuesta['error']) && !empty($arrayRespuesta['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayRespuesta['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        if($conImagen == 'SI')
        {
            foreach ($arrayRespuesta['resultados'] as &$item)
            {
                if($item['IMAGEN'])
                {
                    $item['IMAGEN'] = $objController->getImgBase64($item['IMAGEN']);
                }
            }
        }
        $arrayRespuesta['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayRespuesta,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
}
