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
class AdmiAccionController extends Controller
{
    /**
     * @Route("/createAccion")
     */
    public function createAccionAction()
    {
        return $this->render('AppBundle:AdmiAccion:create_accion.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/editAccion")
     */
    public function editAccionAction()
    {
        return $this->render('AppBundle:AdmiAccion:edit_accion.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/getAccion")
     *
     * Documentación para la función 'getAccion'
     * Método encargado de retornar todos las acciones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 11-09-2019
     * 
     * @return array  $objResponse
     */
    public function getAccionAction(Request $request)
    {
        $intIdAccion            = $request->query->get("idAccion") ? $request->query->get("idAccion"):'';
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $arrayAccion            = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        try
        {
            $arrayParametros = array('intIdAccion'    => $intIdAccion,
                                    'strDescripcion' => $strDescripcion,
                                    'strEstado'      => $strEstado
                                    );
            $arrayAccion   = $this->getDoctrine()->getRepository('AppBundle:AdmiAccion')->getAccionCriterio($arrayParametros);
            if(isset($arrayAccion['error']) && !empty($arrayAccion['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayAccion['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayAccion['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayAccion,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

}
