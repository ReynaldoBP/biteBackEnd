<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class UsuarioController extends Controller
{
    /**
     * @Route("/getUsuario")
     */
    public function getUsuarioAction()
    {
        $arrayParametros = array('estado'    => 'ACTIVO');
        $arrayUsuarios   = array();
        $strMensaje      = true;
        $strStatus       = 400;
        $objResponse     = new Response;
        try
        {
            //$arrayUsuarios   = $this->getDoctrine()->getRepository('AppBundle:InfoUsuario')->getUsuarios($arrayParametros);
            $arrayUsuarios = $this->getDoctrine()->getRepository('AppBundle:InfoUsuario')->findBy(array('ESTADO'    => 'ACTIVO'));
            if( isset($arrayUsuarios['resultados']) &&  empty($arrayUsuarios['resultados']) ) 
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
                                            'result'  => $arrayUsuarios
                                            )
                                        ));
        return $objResponse;
    }
}
