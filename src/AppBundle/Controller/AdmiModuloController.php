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
use AppBundle\Entity\InfoUsuario;
class AdmiModuloController extends Controller
{
    /**
     * @Route("/createModulo")
     */
    public function createModuloAction()
    {
        return $this->render('AppBundle:AdmiModulo:create_modulo.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/editModulo")
     */
    public function editModuloAction()
    {
        return $this->render('AppBundle:AdmiModulo:edit_modulo.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/getModulo")
     *
     * Documentación para la función 'getModulo'
     * Método encargado de retornar todos los modulos según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 11-09-2019
     * 
     * @return array  $objResponse
     */
    public function getModuloAction(Request $request)
    {
        $intIdModulo            = $request->query->get("idModulo") ? $request->query->get("idModulo"):'';
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $arrayModulo            = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        try
        {
            $arrayParametros = array('intIdModulo'    => $intIdModulo,
                                    'strDescripcion' => $strDescripcion,
                                    'strEstado'      => $strEstado
                                    );
            $arrayModulo   = $this->getDoctrine()->getRepository('AppBundle:AdmiModulo')->getModuloCriterio($arrayParametros);
            if(isset($arrayModulo['error']) && !empty($arrayModulo['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayModulo['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayModulo['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayModulo,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

}
