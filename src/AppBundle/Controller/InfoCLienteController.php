<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoCliente;
class InfoCLienteController extends Controller
{
    /**
     * @Route("/editCliente")
     *
     * Documentación para la función 'editCliente'
     * Método encargado de editar los clientes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 03-10-2019
     * 
     * @return array  $objResponse
     */
    public function editClienteAction(Request $request)
    {
        $strEstado             = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $intIdCliente          = $request->query->get("idCliente") ? $request->query->get("idCliente"):'';
        $strMensajeError       = '';
        $strStatus             = 400;
        $objResponse           = new Response;
        $em                    = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $objCliente = $em->getRepository('AppBundle:InfoCliente')->findOneBy(array('id'=>$intIdCliente));
            if(!is_object($objCliente) || empty($objCliente))
            {
                throw new \Exception('No existe cliente con la identificación enviada por parámetro.');
            }
            if(!empty($strEstado))
            {
                $objCliente->setESTADO(strtoupper($strEstado));
            }
            $objCliente->setUSRMODIFICACION($strUsuarioCreacion);
            $objCliente->setFEMODIFICACION($strDatetimeActual);
            $em->persist($objCliente);
            $em->flush();
            $strMensajeError = 'Cliente editado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al editar una encuesta, intente nuevamente.\n ". $ex->getMessage();
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
