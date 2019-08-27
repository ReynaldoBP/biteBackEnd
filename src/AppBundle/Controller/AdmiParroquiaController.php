<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\AdmiCiudad;
use AppBundle\Entity\AdmiParroquia;
class AdmiParroquiaController extends Controller
{
    /**
     * @Route("/getParroquia")
     */
    public function getParroquiaAction(Request $request)
    {
        $strEstado       = $request->query->get("estado") ? $request->query->get("estado"):'';
        $intIdCiudad     = $request->query->get("idCiudad") ? $request->query->get("idCiudad"):'';
        $intIdParroquia  = $request->query->get("idParroquia") ? $request->query->get("idParroquia"):'';
        $strMensajeError = '';
        $arrayParroquia  = array();
        $strStatus       = 400;
        $objResponse     = new Response;
        $em              = $this->getDoctrine()->getEntityManager();

        try
        {
            $arrayParametros = array('estado'      => $strEstado,
                                     'idCiudad'    => $intIdCiudad,
                                     'idParroquia' => $intIdParroquia);
            $arrayParroquia  = $this->getDoctrine()->getRepository('AppBundle:AdmiParroquia')->getParroquia($arrayParametros);
            if( isset($arrayParroquia['error']) && !empty($arrayParroquia['error']) ) 
            {
                $strStatus  = 404;
                throw new \Exception($arrayParroquia['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError    = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayParroquia['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayParroquia,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
}
