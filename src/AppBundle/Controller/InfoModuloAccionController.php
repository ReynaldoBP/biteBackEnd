<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoPerfil;
use AppBundle\Entity\AdmiAccion;
use AppBundle\Entity\AdmiModulo;
use AppBundle\Entity\InfoModuloAccion;
class InfoModuloAccionController extends Controller
{
    /**
     * @Route("/getModuloAccion")
     *
     * Documentación para la función 'getModuloAccion'
     * Método encargado de listar los modulos y acciones relacionados, según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 05-10-2019
     * 
     * @return array  $objResponse
     */
    public function getModuloAccionAction(Request $request)
    {
        $intIdModuloAccion      = $request->query->get("idModuloAccion") ? $request->query->get("idModuloAccion"):'';
        $intIdModulo            = $request->query->get("idModulo") ? $request->query->get("idModulo"):'';
        $intIdAccion            = $request->query->get("idAccion") ? $request->query->get("idAccion"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $arrayParametros = array('intIdModulo'      => $intIdModulo,
                                    'intIdModuloAccion' => $intIdModuloAccion,
                                    'intIdAccion'       => $intIdAccion,
                                    'strEstado'         => $strEstado
                                    );
            $arrayModuloAccion   = $this->getDoctrine()->getRepository('AppBundle:InfoModuloAccion')->getModuloAccionCriterio($arrayParametros);
            if(isset($arrayModuloAccion['error']) && !empty($arrayModuloAccion['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayModuloAccion['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayModuloAccion['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayModuloAccion,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
}
