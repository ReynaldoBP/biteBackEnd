<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\AdmiCiudad;

class CiudadController extends Controller
{
    /**
     * @Route("/getCiudad")
     */
    public function getCiudadAction(Request $request)
    {
        $strEstado             = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strProvincia          = $request->query->get("provincia") ? $request->query->get("provincia"):'';
        $arrayCiudad           = array();
        $strMensajeError       = '';
        $strStatus             = 400;
        $objResponse           = new Response;
        $em                    = $this->getDoctrine()->getEntityManager();
        try
        {
            $arrayParametros = array('estado'    => $strEstado,
                                     'provincia' => $strProvincia);
            $arrayCiudad     = $this->getDoctrine()->getRepository('AppBundle:AdmiCiudad')->getCiudad($arrayParametros);
            if( isset($arrayCiudad['error']) && !empty($arrayCiudad['error']) ) 
            {
                throw new \Exception($arrayPais['error']);
                $strStatus  = 404;
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
            if(isset($arrayCiudad['error']))
            {
                $arrayCiudad['error'] = $strMensajeError.' '.$arrayCiudad['error'];
            }
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayCiudad,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

}
