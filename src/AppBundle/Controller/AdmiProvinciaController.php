<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\AdmiRegion;
use AppBundle\Entity\AdmiPais;
use AppBundle\Entity\AdmiProvincia;
class AdmiProvinciaController extends Controller
{
    /**
     * @Route("/getProvincia")
     */
    public function getProvinciaAction(Request $request)
    {
        $strEstado       = $request->query->get("estado") ? $request->query->get("estado"):'Activo';
        $intIdRegion     = $request->query->get("idRegion") ? $request->query->get("idRegion"):'';
        $strMensajeError = '';
        $arrayProvincia  = array();
        $strStatus       = 400;
        $objResponse     = new Response;
        $em              = $this->getDoctrine()->getEntityManager();
        try
        {
            $arrayParametros = array('estado'    => $strEstado,'idRegion'=>$intIdRegion);
            $arrayProvincia = $this->getDoctrine()->getRepository('AppBundle:AdmiProvincia')->getProvincia($arrayParametros);
            if( isset($arrayProvincia['error']) && !empty($arrayProvincia['error']) ) 
            {
                throw new \Exception($arrayProvincia['error']);
                $strStatus  = 404;
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError    = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayProvincia['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayProvincia,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

}
