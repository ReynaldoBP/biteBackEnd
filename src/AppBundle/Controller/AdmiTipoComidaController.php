<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class AdmiTipoComidaController extends Controller
{
    /**
     * @Route("/getTipoComida")
     */
    public function getTipoComidaAction(Request $request)
    {
        $strEstado       = $request->query->get("estado") ? $request->query->get("estado"):'';
        $arrayParametros = array('estado'    => $strEstado);
        $arrayTipoComida = array();
        $strMensajeError = '';
        $strStatus       = 400;
        $objResponse     = new Response;
        try
        {
            $arrayTipoComida = $this->getDoctrine()->getRepository('AppBundle:AdmiTipoComida')->getTipoComida($arrayParametros);
            if( isset($arrayTipoComida['error']) && !empty($arrayTipoComida['error']) ) 
            {
                throw new \Exception($arrayTipoComida['error']);
                $strStatus  = 404;
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError    = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
            if(isset($arrayTipoComida['error']))
            {
                $arrayTipoComida['error'] = $strMensajeError;
            }
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayTipoComida,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * @Route("/editTipoComida")
     */
    public function editTipoComidaAction()
    {
        return $this->render('AppBundle:AdmiTipoComida:edit_tipo_comida.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/createTipoComida")
     */
    public function createTipoComidaAction()
    {
        return $this->render('AppBundle:AdmiTipoComida:create_tipo_comida.html.twig', array(
            // ...
        ));
    }

}
