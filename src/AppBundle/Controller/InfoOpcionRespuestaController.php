<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\InfoOpcionRespuesta;
class InfoOpcionRespuestaController extends Controller
{
    /**
     * @Route("/getOpcionRespuesta")
     */
    public function getOpcionRespuestaAction(Request $request)
    {
        $intIdOpcionRespuesta = $request->query->get("idOpcionRespuesta") ? $request->query->get("idOpcionRespuesta"):'';
        $strEstado            = $request->query->get("estado") ? $request->query->get("estado"):'';
        $arrayOpcionRespuesta = array();
        $strMensajeError      = '';
        $strStatus            = 400;
        $objResponse          = new Response;
        try
        {
            $arrayParametros      = array('intIdOpcionRespuesta' => $intIdOpcionRespuesta,
                                          'strEstado'            => $strEstado);
            $arrayOpcionRespuesta = $this->getDoctrine()->getRepository('AppBundle:InfoOpcionRespuesta')->getOpcionRespuesta($arrayParametros);
            if( isset($arrayOpcionRespuesta['error']) && !empty($arrayOpcionRespuesta['error']) ) 
            {
                $strStatus  = 404;
                throw new \Exception($arrayOpcionRespuesta['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError    = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayOpcionRespuesta['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayOpcionRespuesta,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * @Route("/createOpcionRespuesta")
     */
    public function createOpcionRespuestaAction()
    {
        return $this->render('AppBundle:InfoOpcionRespuesta:create_opcion_respuesta.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/editOpcionRespuesta")
     */
    public function editOpcionRespuestaAction()
    {
        return $this->render('AppBundle:InfoOpcionRespuesta:edit_opcion_respuesta.html.twig', array(
            // ...
        ));
    }

}
