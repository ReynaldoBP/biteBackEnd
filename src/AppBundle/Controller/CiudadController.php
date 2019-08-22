<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\AdmiCiudad;
use AppBundle\Entity\AdmiProvincia;
class CiudadController extends Controller
{
    /**
     * @Route("/getCiudad")
     */
    public function getCiudadAction(Request $request)
    {
        $strEstado             = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strProvincia          = $request->query->get("idProvincia") ? $request->query->get("idProvincia"):'';
        $intCiudad             = $request->query->get("idCiudad") ? $request->query->get("idCiudad"):'';
        $arrayCiudad           = array();
        $strMensajeError       = '';
        $strStatus             = 400;
        $objResponse           = new Response;
        $em                    = $this->getDoctrine()->getEntityManager();
        try
        {
            $arrayParametros = array('estado'      => $strEstado,
                                     'idCiudad'    => $intCiudad,
                                     'idProvincia' => $strProvincia);
            $arrayCiudad     = $this->getDoctrine()->getRepository('AppBundle:AdmiCiudad')->getCiudad($arrayParametros);
            if( isset($arrayCiudad['error']) && !empty($arrayCiudad['error']) ) 
            {
                $strStatus  = 404;
                throw new \Exception($arrayCiudad['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayCiudad['error'] = $strMensajeError;
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
