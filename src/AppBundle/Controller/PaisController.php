<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class PaisController extends Controller
{
    /**
     * @Route("/getPais")
     */
    public function getPaisAction(Request $request)
    {
        $strEstado       = $request->query->get("estado") ? $request->query->get("estado"):'';
        $arrayParametros = array('estado'    => $strEstado);
        $arrayPais       = array();
        $strMensajeError = '';
        $strStatus       = 400;
        $objResponse     = new Response;
        try
        {
            $arrayPais = $this->getDoctrine()->getRepository('AppBundle:AdmiPais')->getPais($arrayParametros);
            if( isset($arrayPais['error']) && !empty($arrayPais['error']) ) 
            {
                throw new \Exception($arrayPais['error']);
                $strStatus  = 404;
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError    = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
            if(isset($arrayCiudad['error']))
            {
                $arrayPais['error'] = $strMensajeError.' '.$arrayPais['error'];
            }
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $strEstado,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
}
