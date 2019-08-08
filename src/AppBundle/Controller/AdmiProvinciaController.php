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
            $objRegion   = $em->getRepository('AppBundle:AdmiRegion')->find($intIdRegion);
            if(empty($objRegion))
            {
                $strStatus  = 404;
                throw new \Exception('Region no existe.');
            }
            $objProvincia = $em->getRepository('AppBundle:AdmiProvincia')->findBy(array('ESTADO'  => $strEstado,
                                                                                        'REGION_ID' => $objRegion));

            foreach($objProvincia as $objItemProvincia)
            {
                $arrayProvincia [] = array('ID_PROVINCIA'     =>$objItemProvincia->getId(),
                                           'PROVINCIA_NOMBRE' =>$objItemProvincia->getPROVINCIANOMBRE(),
                                           'ESTADO'           =>$objItemProvincia->getESTADO(),
                                           'NOMBRE_REGION'    =>$objItemProvincia->getREGIONID()->getREGION_NOMBRE());
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
