<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\AdmiTipoRol;

class AdmiTipoRolController extends Controller
{
    /**
     * @Route("/getTipoRol")
     */
    public function getTipoRolAction(Request $request)
    {
        $strEstado             = $request->query->get("estado") ? $request->query->get("estado"):'';
        $strDescripcion        = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $intIdTipoRol          = $request->query->get("idTipoRol") ? $request->query->get("idTipoRol"):'';
        $arrayTipoRol           = array();
        $strMensajeError       = '';
        $strStatus             = 400;
        $objResponse           = new Response;
        $em                    = $this->getDoctrine()->getEntityManager();
        try
        {
            $arrayParametros = array('estado'      => $strEstado,
                                     'descripcion' => $strDescripcion,
                                     'idTipoRol'   => $intIdTipoRol);
            $arrayTipoRol     = $this->getDoctrine()->getRepository('AppBundle:AdmiTipoRol')->getTipoRol($arrayParametros);
            if( isset($arrayTipoRol['error']) && !empty($arrayTipoRol['error']) ) 
            {
                $strStatus  = 404;
                throw new \Exception($arrayTipoRol['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayTipoRol['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayTipoRol,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * @Route("/editTipoRol")
     */
    public function editTipoRolAction()
    {
        return $this->render('AppBundle:AdmiTipoRol:edit_tipo_rol.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/createTipoRol")
     */
    public function createTipoRolAction()
    {
        return $this->render('AppBundle:AdmiTipoRol:create_tipo_rol.html.twig', array(
            // ...
        ));
    }

}
