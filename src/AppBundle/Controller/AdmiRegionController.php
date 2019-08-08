<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\AdmiRegion;
use AppBundle\Entity\AdmiPais;
class AdmiRegionController extends Controller
{
    /**
     * @Route("/getRegion")
     */
    public function getRegionAction(Request $request)
    {
        $strEstado       = $request->query->get("estado") ? $request->query->get("estado"):'Activo';
        $intIdPais       = $request->query->get("idPais") ? $request->query->get("idPais"):1;
        $strMensajeError = '';
        $mensaje='';
        $arrayRegion     = array();
        $strStatus       = 400;
        $objResponse     = new Response;
        $em              = $this->getDoctrine()->getEntityManager();

        try
        {
            $objPais   = $em->getRepository('AppBundle:AdmiPais')->find($intIdPais);
            $objRegion = $em->getRepository('AppBundle:AdmiRegion')->findBy(array('ESTADO'  => $strEstado,
                                                                                  'PAIS_ID' => $objPais));
            if(empty($objRegion))
            {
                $strStatus  = 404;
                throw new \Exception('Region no existe.');
            }
            foreach($objRegion as $objItemRegion)
            {
                $arrayRegion [] = array( 'ID_REGION'     => $objItemRegion->getId(),
                                         'REGION_NOMBRE' => $objItemRegion->getREGION_NOMBRE(),
                                         'ESTADO'        => $objItemRegion->getESTADO(),
                                         'PAIS_ID'       => $objItemRegion->getPAIS_ID()->getId());
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError    = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayRegion['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayRegion,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

}
