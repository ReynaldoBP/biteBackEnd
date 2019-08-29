<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\AdmiTipoComida;
class AdmiTipoComidaController extends Controller
{
    /**
     * @Route("/getTipoComida")
     *
     * Documentación para la función 'getTipoComida'
     * Método encargado de listar los tipos de comida según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 29-08-2019
     * 
     * @return array  $objResponse
     */
    public function getTipoComidaAction(Request $request)
    {
        $strEstado       = $request->query->get("estado") ? $request->query->get("estado"):'';
        $intIdTipoComida = $request->query->get("idTipoComida") ? $request->query->get("idTipoComida"):'';
        $arrayParametros = array('estado'       => $strEstado,
                                 'idTipoComida' => $intIdTipoComida);
        $arrayTipoComida = array();
        $strMensajeError = '';
        $strStatus       = 400;
        $objResponse     = new Response;
        try
        {
            $arrayTipoComida = $this->getDoctrine()->getRepository('AppBundle:AdmiTipoComida')->getTipoComida($arrayParametros);
            if( isset($arrayTipoComida['error']) && !empty($arrayTipoComida['error']) ) 
            {
                $strStatus  = 404;
                throw new \Exception($arrayTipoComida['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError    = "Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayTipoComida['error'] = $strMensajeError;
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
     *
     * Documentación para la función 'editTipoComida'
     * Método encargado de editar los tipos de comida según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 29-08-2019
     * 
     * @return array  $objResponse
     */
    public function editTipoComidaAction(Request $request)
    {
        $intIdTipoComida        = $request->query->get("idTipoComida") ? $request->query->get("idTipoComida"):'';
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $entityComida = $em->getRepository('AppBundle:AdmiTipoComida')->findOneBy(array('id'=>$intIdTipoComida));
            $entityComida->setDESCRIPCION($strDescripcion);
            $entityComida->setESTADO(strtoupper($strEstado));
            $entityComida->setUSRMODIFICACION($strUsuarioCreacion);
            $entityComida->setFEMODIFICACION($strDatetimeActual);
            $em->persist($entityComida);
            $em->flush();
            $strMensajeError = 'Tipo de comida editado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al editar un Tipo de comida, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $strMensajeError,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * @Route("/createTipoComida")
     *
     * Documentación para la función 'createTipoComida'
     * Método encargado de crear los tipos de comida según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 29-08-2019
     * 
     * @return array  $objResponse
     */
    public function createTipoComidaAction(Request $request)
    {
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $entityComida = new AdmiTipoComida();
            $entityComida->setDESCRIPCION($strDescripcion);
            $entityComida->setESTADO(strtoupper($strEstado));
            $entityComida->setUSRCREACION($strUsuarioCreacion);
            $entityComida->setFECREACION($strDatetimeActual);
            $em->persist($entityComida);
            $em->flush();
            $strMensajeError = 'Tipo de comida creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al crear un Tipo de comida, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $strMensajeError,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

}
