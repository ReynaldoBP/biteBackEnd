<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoEncuesta;
use AppBundle\Entity\InfoPregunta;
class InfoPreguntaController extends Controller
{
    /**
     * @Route("/createPregunta")
     *
     * Documentación para la función 'createPregunta'
     * Método encargado de crear las preguntas según los parámetros recibidos.
     *
     * @author Kevin Baque
     * @version 1.0 29-08-2019
     * 
     * @return array  $objResponse
     */
    public function createPreguntaAction(Request $request)
    {
        $strIdEncuesta          = $request->query->get("idEncuesta") ? $request->query->get("idEncuesta"):'';
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $strObligatoria         = $request->query->get("obligatoria") ? $request->query->get("obligatoria"):'';
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
            $objEncuesta = $em->getRepository('AppBundle:InfoEncuesta')->find($strIdEncuesta);
            if(!is_object($objEncuesta) || empty($objEncuesta))
            {
                throw new \Exception('No existe encuesta con la parámetros enviados.');
            }
            $entityPregunta = new InfoPregunta();
            $entityPregunta->setENCUESTAID($objEncuesta);
            $entityPregunta->setDESCRIPCION($strDescripcion);
            $entityPregunta->setOBLIGATORIA($strObligatoria);
            $entityPregunta->setESTADO(strtoupper($strEstado));
            $entityPregunta->setUSRCREACION($strUsuarioCreacion);
            $entityPregunta->setFECREACION($strDatetimeActual);
            $em->persist($entityPregunta);
            $em->flush();
            $strMensajeError = 'Pregunta creada con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al crear una Pregunta, intente nuevamente.\n ". $ex->getMessage();
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
     * @Route("/editPregunta")
     *
     * Documentación para la función 'editPregunta'
     * Método encargado de crear las preguntas según los parámetros recibidos.
     *
     * @author Kevin Baque
     * @version 1.0 29-08-2019
     * 
     * @return array  $objResponse
     */
    public function editPreguntaAction(Request $request)
    {
        $strIdPregunta          = $request->query->get("idPregunta") ? $request->query->get("idPregunta"):'';
        $strIdEncuesta          = $request->query->get("idEncuesta") ? $request->query->get("idEncuesta"):'';
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $strObligatoria         = $request->query->get("obligatoria") ? $request->query->get("obligatoria"):'';
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
            $objPregunta = $em->getRepository('AppBundle:InfoPregunta')->findOneBy(array('id'=>$strIdPregunta));
            if(!is_object($objPregunta) || empty($objPregunta))
            {
                throw new \Exception('No existe pregunta con la identificación enviada por parámetro.');
            }
            if(!empty($strIdEncuesta))
            {
                $objEncuesta  = $em->getRepository('AppBundle:InfoEncuesta')->find($strIdEncuesta);
                if(!is_object($objEncuesta) || empty($objEncuesta))
                {
                    throw new \Exception('No existe encuesta con la descripción enviada por parámetro.');
                }
                $objPregunta->setENCUESTAID($objEncuesta);
            }
            if(!empty($strDescripcion))
            {
                $objPregunta->setDESCRIPCION($strDescripcion);
            }
            if(!empty($strObligatoria))
            {
                $objPregunta->setOBLIGATORIA($strObligatoria);
            }
            if(!empty($strEstado))
            {
                $objPregunta->setESTADO(strtoupper($strEstado));
            }
            $objPregunta->setUSRMODIFICACION($strUsuarioCreacion);
            $objPregunta->setFEMODIFICACION($strDatetimeActual);
            $em->persist($objPregunta);
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
     * @Route("/getPregunta")
     *
     * Documentación para la función 'getPregunta'
     * Método encargado de listar las preguntas según los parámetros recibidos.
     *
     * @author Kevin Baque
     * @version 1.0 29-08-2019
     * 
     * @return array  $objResponse
     */
    public function getPreguntaAction(Request $request)
    {
        $strIdEncuesta          = $request->query->get("idEncuesta") ? $request->query->get("idEncuesta"):'';
        $strIdPregunta          = $request->query->get("idPregunta") ? $request->query->get("idPregunta"):'';
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $strObligatoria         = $request->query->get("obligatoria") ? $request->query->get("obligatoria"):'';
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
            $arrayParametros = array('strIdPregunta'    => $strIdPregunta,
                                    'strIdEncuesta'     => $strIdEncuesta,
                                    'strDescripcion'    => $strDescripcion,
                                    'strObligatoria'    => $strObligatoria,
                                    'strEstado'         => $strEstado
                                    );
            $arrayEncuesta = $this->getDoctrine()->getRepository('AppBundle:InfoPregunta')->getPreguntaCriterio($arrayParametros);
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
