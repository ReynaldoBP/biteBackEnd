<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoEncuesta;
use AppBundle\Entity\InfoRestaurante;

class InfoEncuestaController extends Controller
{
    /**
     * @Route("/createEncuesta")
     *
     * Documentación para la función 'createEncuesta'
     * Método encargado de crear las encuestas según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 29-08-2019
     * 
     * @return array  $objResponse
     */
    public function createEncuestaAction(Request $request)
    {
        $strIdRestaurante       = $request->query->get("idRestaurante") ? $request->query->get("idRestaurante"):'';
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $strTitulo              = $request->query->get("titulo") ? $request->query->get("titulo"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        $arrayEncuesta          = array();
        try
        {
            $em->getConnection()->beginTransaction();
            $objRestaurante = $em->getRepository('AppBundle:InfoRestaurante')->find($strIdRestaurante);
            if(!is_object($objRestaurante) || empty($objRestaurante))
            {
                throw new \Exception('No existe restaurante con la parámetros enviados.');
            }
            $entityEncuesta = new InfoEncuesta();
            $entityEncuesta->setRESTAURANTEID($objRestaurante);
            $entityEncuesta->setDESCRIPCION($strDescripcion);
            $entityEncuesta->setTITULO($strTitulo);
            $entityEncuesta->setESTADO(strtoupper($strEstado));
            $entityEncuesta->setUSRCREACION($strUsuarioCreacion);
            $entityEncuesta->setFECREACION($strDatetimeActual);
            $em->persist($entityEncuesta);
            $em->flush();
            $strMensajeError = 'Encuesta creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al crear una encuesta, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
        }
        $arrayEncuesta = array( 'id'                        => $entityEncuesta->getId(),
                                'descripcion'               => $entityEncuesta->getDESCRIPCION(),
                                'titulo'                    => $entityEncuesta->getTITULO(),
                                'idRestaurante'             => $entityEncuesta->getRESTAURANTEID()->getId(),
                                'identificacionRestaurante' => $entityEncuesta->getRESTAURANTEID()->getIDENTIFICACION(),
                                'razonSocialRestaurante'    => $entityEncuesta->getRESTAURANTEID()->getRAZONSOCIAL(),
                                'estadoRestaurante'         => $entityEncuesta->getRESTAURANTEID()->getESTADO(),
                                'estadoEncuesta'            => $entityEncuesta->getESTADO(),
                                'usrCreacion'               => $entityEncuesta->getUSRCREACION(),
                                'feModificacion'            => $entityEncuesta->getUSRCREACION(),
                                'mensaje'                   => $strMensajeError);

        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayEncuesta,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * @Route("/editEncuesta")
     *
     * Documentación para la función 'editEncuesta'
     * Método encargado de editar las encuestas según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function editEncuestaAction(Request $request)
    {
        $strIdRestaurante       = $request->query->get("idRestaurante") ? $request->query->get("idRestaurante"):'';
        $strIdEncuesta          = $request->query->get("idEncuesta") ? $request->query->get("idEncuesta"):'';
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $strTitulo              = $request->query->get("titulo") ? $request->query->get("titulo"):'';
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
            $objEncuesta = $em->getRepository('AppBundle:InfoEncuesta')->findOneBy(array('id'=>$strIdEncuesta));
            if(!is_object($objEncuesta) || empty($objEncuesta))
            {
                throw new \Exception('No existe encuesta con la identificación enviada por parámetro.');
            }
            if(!empty($strIdRestaurante))
            {
                $objRestaurante  = $em->getRepository('AppBundle:InfoRestaurante')->find($strIdRestaurante);
                if(!is_object($objRestaurante) || empty($objRestaurante))
                {
                    throw new \Exception('No existe restaurante con la descripción enviada por parámetro.');
                }
                $objEncuesta->setRESTAURANTEID($objRestaurante);
            }
            if(!empty($strDescripcion))
            {
                $objEncuesta->setDESCRIPCION($strDescripcion);
            }
            if(!empty($strTitulo))
            {
                $objEncuesta->setTITULO($strTitulo);
            }
            if(!empty($strEstado))
            {
                $objEncuesta->setESTADO(strtoupper($strEstado));
            }
            $objEncuesta->setUSRMODIFICACION($strUsuarioCreacion);
            $objEncuesta->setFEMODIFICACION($strDatetimeActual);
            $em->persist($objEncuesta);
            $em->flush();
            $strMensajeError = 'Encuesta editada con exito.!';
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

    /**
     * @Route("/getEncuesta")
     *
     * Documentación para la función 'getEncuesta'
     * Método encargado de listar las encuestas según los parámetros recibidos.
     *
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     *
     * @return array  $objResponse
     */
    public function getEncuestaAction(Request $request)
    {
        $strIdRestaurante       = $request->query->get("idRestaurante") ? $request->query->get("idRestaurante"):'';
        $strIdEncuesta          = $request->query->get("idEncuesta") ? $request->query->get("idEncuesta"):'';
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $strTitulo              = $request->query->get("titulo") ? $request->query->get("titulo"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strContador            = $request->query->get("strContador") ? $request->query->get("strContador"):'NO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $arrayParametros = array('strIdRestaurante' => $strIdRestaurante,
                                    'strIdEncuesta'     => $strIdEncuesta,
                                    'strDescripcion'    => $strDescripcion,
                                    'strTitulo'         => $strTitulo,
                                    'strContador'       => $strContador,
                                    'strEstado'         => $strEstado
                                    );
            $arrayEncuesta = $this->getDoctrine()->getRepository('AppBundle:InfoEncuesta')->getEncuestaCriterio($arrayParametros);
            if(isset($arrayEncuesta['error']) && !empty($arrayEncuesta['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayEncuesta['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensaje ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayEncuesta['error'] = $strMensaje;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayEncuesta,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

}
