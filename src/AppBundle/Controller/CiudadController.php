<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CiudadController extends Controller
{
    /**
     * @Route("/getCiudad")
     */
    public function getCiudadAction()
    {
        $arrayParametros = array('estado'    => 'ACTIVO');
        $arrayPais       = array();
        $strMensaje      = true;
        $strStatus       = 400;
        $objResponse     = new Response;
        try
        {
            $arrayPais   = $this->getDoctrine()->getRepository('AppBundle:Ciudad')->getCiudad($arrayParametros);
            if( isset($arrayPais['resultados']) &&  empty($arrayPais['resultados']) ) 
            {
                $strMensaje = false;
                $strStatus  = 404;
            }
        }
        catch(\Exception $ex)
        {
            $strMensaje ="Fallo al realizar la busqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'  => $strStatus,
                                            'message' => $strMensaje,
                                            'result'  => $arrayPais
                                            )
                                        ));
        return $objResponse;
    }

}
