<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoUsuario;
use AppBundle\Entity\InfoRestaurante;
use AppBundle\Entity\InfoUsuarioRes;

class InfoUsuarioResController extends Controller
{
    /**
     * @Route("/createUsuarioRes")
     *
     * Documentación para la función 'createUsuarioRes'
     * Método encargado de crear las relaciones entre usuario y restaurante según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 15-09-2019
     * 
     * @return array  $objResponse
     */
    public function createUsuarioResAction(Request $request)
    {
        $intIdRestaurante       = $request->query->get("idRestaurante") ? $request->query->get("idRestaurante"):'';
        $intIdUsuario           = $request->query->get("idUsuario") ? $request->query->get("idUsuario"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $arrayParametrosRestaurante = array('ESTADO' => 'ACTIVO',
                                                'id'     => $intIdRestaurante);
            $objRestaurante             = $em->getRepository('AppBundle:InfoRestaurante')->findOneBy($arrayParametrosRestaurante);
            if(!is_object($objRestaurante) || empty($objRestaurante))
            {
                throw new \Exception('No existe el restaurante con la descripción enviada por parámetro.');
            }
            $arrayParametrosUs = array('ESTADO' => 'ACTIVO',
                                       'id'     => $intIdUsuario);
            $objUsuario        = $em->getRepository('AppBundle:InfoUsuario')->findOneBy($arrayParametrosUs);
            if(!is_object($objUsuario) || empty($objUsuario))
            {
                throw new \Exception('No existe el usuario con la descripción enviada por parámetro.');
            }
            $arrayParametrosRelacion = array('ESTADO'        => 'ACTIVO',
                                             'USUARIOID'     => $intIdUsuario,
                                             'RESTAURANTEID' => $intIdRestaurante);
            $objUsuarioRes          = $em->getRepository('AppBundle:InfoUsuarioRes')->findOneBy($arrayParametrosRelacion);
            if(is_object($objUsuarioRes) && !empty($objUsuarioRes))
            {
                throw new \Exception('Relación ya existente.');
            }
            $entityUsuarioRes = new InfoUsuarioRes();
            $entityUsuarioRes->setRESTAURANTEID($objRestaurante);
            $entityUsuarioRes->setUSUARIOID($objUsuario);
            $entityUsuarioRes->setESTADO(strtoupper($strEstado));
            $entityUsuarioRes->setUSRCREACION($strUsuarioCreacion);
            $entityUsuarioRes->setFECREACION($strDatetimeActual);
            $em->persist($entityUsuarioRes);
            $em->flush();
            $strMensajeError = 'Relación entre Usuario y Restaurante creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al crear una Relación entre Usuario y Restaurante, intente nuevamente.\n ". $ex->getMessage();
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
     * @Route("/editUsuarioRes")
     *
     * Documentación para la función 'editUsuarioRes'
     * Método encargado de editar las relaciones entre usuario y restaurante según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 15-09-2019
     * 
     * @return array  $objResponse
     */
    public function editUsuarioResAction(Request $request)
    {
        $intIdUsuarioRes        = $request->query->get("idUsuarioRes") ? $request->query->get("idUsuarioRes"):'';
        $intIdRestaurante       = $request->query->get("idRestaurante") ? $request->query->get("idRestaurante"):'';
        $intIdUsuario           = $request->query->get("idUsuario") ? $request->query->get("idUsuario"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $objUsuarioRes = $em->getRepository('AppBundle:InfoUsuarioRes')->findOneBy(array('id'=>$intIdUsuarioRes));
            if(!is_object($objUsuarioRes) || empty($objUsuarioRes))
            {
                throw new \Exception('No existe una Relación entre Usuario y Restaurante con la descripción enviada por parámetro.');
            }
            if(!empty($intIdRestaurante))
            {
                $arrayParametrosRes    = array('ESTADO' => 'ACTIVO',
                                               'id'     => $intIdRestaurante);
                $objRestaurante        = $em->getRepository('AppBundle:InfoRestaurante')->findOneBy($arrayParametrosRes);
                if(!is_object($objRestaurante) || empty($objRestaurante))
                {
                    throw new \Exception('No existe el Restaurante con la descripción enviada por parámetro.');
                }
                $objUsuarioRes->setRESTAURANTEID($objRestaurante);
            }
            if(!empty($intIdUsuario))
            {
                $arrayParametrosUs = array('ESTADO' => 'ACTIVO',
                                           'id'     => $intIdUsuario);
                $objUsuario        = $em->getRepository('AppBundle:InfoUsuario')->findOneBy($arrayParametrosUs);
                if(!is_object($objUsuario) || empty($objUsuario))
                {
                    throw new \Exception('No existe el usuario con la descripción enviada por parámetro.');
                }
                $objUsuarioRes->setUSUARIOID($objUsuario);
            }

            if(!empty($strEstado))
            {
                $objUsuarioRes->setESTADO(strtoupper($strEstado));
            }
            $objUsuarioRes->setUSRMODIFICACION($strUsuarioCreacion);
            $objUsuarioRes->setFEMODIFICACION($strDatetimeActual);
            $em->persist($objUsuarioRes);
            $em->flush();
            $strMensajeError = 'Relación entre Usuario y Restaurante editado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            
            $strMensajeError = "Fallo al editar una Relación entre Usuario y Restaurante, intente nuevamente.\n ". $ex->getMessage();
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
     * @Route("/getUsuarioRes")
     *
     * Documentación para la función 'getUsuarioRes'
     * Método encargado de retornar las relaciones entre usuario y restaurante según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 15-09-2019
     * 
     * @return array  $objResponse
     */
    public function getUsuarioResAction(Request $request)
    {
        $intIdUsuarioRes        = $request->query->get("idUsuarioRes") ? $request->query->get("idUsuarioRes"):'';
        $intIdRestaurante       = $request->query->get("idRestaurante") ? $request->query->get("idRestaurante"):'';
        $intIdUsuario           = $request->query->get("idUsuario") ? $request->query->get("idUsuario"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $arrayUsuarioRes        = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        try
        {
            $arrayParametros = array('intIdUsuarioRes'  => $intIdUsuarioRes,
                                     'intIdRestaurante' => $intIdRestaurante,
                                     'intIdUsuario'     => $intIdUsuario,
                                     'strEstado'        => $strEstado
                                    );
            $arrayUsuarioRes = $this->getDoctrine()->getRepository('AppBundle:InfoUsuarioRes')->getRelacionUsResCriterio($arrayParametros);
            if(isset($arrayUsuarioRes['error']) && !empty($arrayUsuarioRes['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayUsuarioRes['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayUsuarioRes['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayUsuarioRes,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * @Route("/deleteUsuarioRes")
     *
     * Documentación para la función 'deleteUsuarioRes'
     * Método encargado de eliminar las relaciones entre el usuario y el restaurante
     * según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 15-09-2019
     * 
     * @return array  $objResponse
     */
    public function deleteUsuarioResAction(Request $request)
    {
        $intIdUsuario           = $request->query->get("idUsuario") ? $request->query->get("idUsuario"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            if(!empty($intIdUsuario))
            {
                $objUsuario = $em->getRepository('AppBundle:InfoUsuario')->find($intIdUsuario);
                if(!is_object($objUsuario) || empty($objUsuario))
                {
                    throw new \Exception('No existe el usuario con la descripción enviada por parámetro.');
                }
            }
            $objUsuarioRes = $em->getRepository('AppBundle:InfoUsuarioRes')->findBy(array('USUARIOID'=>$intIdUsuario));
            if(empty($objUsuarioRes))
            {
                throw new \Exception('No existe una Relación entre Usuario y Restaurante con la descripción enviada por parámetro.');
            }
            foreach($objUsuarioRes as $item)
            {
                $em->remove($item);
            }
            $em->flush();
            $strMensajeError = 'Relación entre Usuario y Restaurante eliminado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al eliminar una Relación entre Usuario y Restaurante, intente nuevamente.\n ". $ex->getMessage();
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
