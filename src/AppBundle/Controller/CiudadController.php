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
        $arrayCiudad           = array();
        $strMensajeError       = '';
        $strStatus             = 400;
        $objResponse           = new Response;
        $em                    = $this->getDoctrine()->getEntityManager();
        try
        {
            $arrayParametros = array('estado'      => $strEstado,
                                     'idProvincia' => $strProvincia);
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
    /**
     * @Route("/getCiudadPrueba")
     */
    public function getCiudadPruebaAction(Request $request)
    {
        $strEstado       = $request->query->get("estado") ? $request->query->get("estado"):'Activo';
        $intIdProvincia  = $request->query->get("idProvincia") ? $request->query->get("idProvincia"):'';
        $strMensajeError = '';
        $arrayCiudad  = array();
        $strStatus       = 400;
        $objResponse     = new Response;
        $em              = $this->getDoctrine()->getEntityManager();

        try
        {
            $objProvincia   = $em->getRepository('AppBundle:AdmiProvincia')->find($intIdProvincia);
            if(empty($objProvincia))
            {
                $strStatus  = 404;
                throw new \Exception('Provincia no existe.');
            }
            $objCiudad = $em->getRepository('AppBundle:AdmiCiudad')->findBy(array('ESTADO'  => $strEstado,
                                                                                     'PROVINCIA_ID' => $objProvincia));

            foreach($objCiudad as $objItemCiudad)
            {
                $arrayCiudad [] = array('ID_CIUDAD'        => $objItemCiudad->getId(),
                                        'CIUDAD_NOMBRE'    => $objItemCiudad->getCIUDAD_NOMBRE(),
                                        'ESTADO'           => $objItemCiudad->getESTADO(),
                                        'PROVINCIA_NOMBRE' => $objItemCiudad->getPROVINCIA_ID()->getPROVINCIANOMBRE());
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError    = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
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
