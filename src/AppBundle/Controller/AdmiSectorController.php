<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\AdmiSector;
use AppBundle\Entity\AdmiParroquia;
class AdmiSectorController extends Controller
{
    /**
     * @Route("/getSector")
     */
    public function getSectorAction(Request $request)
    {
        $strEstado       = $request->query->get("estado") ? $request->query->get("estado"):'Activo';
        $intIdParroquia  = $request->query->get("idParroquia") ? $request->query->get("idParroquia"):'';
        $strMensajeError = '';
        $arraySector     = array();
        $strStatus       = 400;
        $objResponse     = new Response;
        $em              = $this->getDoctrine()->getEntityManager();

        try
        {
            $arrayParametros = array('estado'      => $strEstado,
                                     'idParroquia' => $intIdParroquia);
            $arraySector  = $this->getDoctrine()->getRepository('AppBundle:AdmiSector')->getSector($arrayParametros);
            if( isset($arraySector['error']) && !empty($arraySector['error']) ) 
            {
                throw new \Exception($arrayPais['error']);
                $strStatus  = 404;
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError    = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arraySector['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arraySector,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
}
