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
class InfoPerfilController extends Controller
{
    /**
     * @Route("/createPerfil")
     *
     * Documentación para la función 'createPerfil'
     * Método encargado de crear los perfiles según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 10-09-2019
     * 
     * @return array  $objResponse
     */
    public function createPerfilAction(Request $request)
    {
        $intIdModulo            = $request->query->get("idModulo") ? $request->query->get("idModulo"):'';
        $intIdAccion            = $request->query->get("idAccion") ? $request->query->get("idAccion"):'';
        $intIdUsuario           = $request->query->get("idUsuario") ? $request->query->get("idUsuario"):'';
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
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
            $arrayParametrosModulo = array('ESTADO' => 'ACTIVO',
                                           'id'     => $intIdModulo);
            $objModulo             = $em->getRepository('AppBundle:AdmiModulo')->findOneBy($arrayParametrosModulo);
            if(!is_object($objModulo) || empty($objModulo))
            {
                throw new \Exception('No existe el módulo con la descripción enviada por parámetro.');
            }
            $arrayParametrosAccion = array('ESTADO' => 'ACTIVO',
                                           'id'     => $intIdAccion);
            $objAccion             = $em->getRepository('AppBundle:AdmiAccion')->findOneBy($arrayParametrosAccion);
            if(!is_object($objAccion) || empty($objAccion))
            {
                throw new \Exception('No existe el acción con la descripción enviada por parámetro.');
            }
            $arrayParametrosUs = array('ESTADO' => 'ACTIVO',
                                       'id'     => $intIdUsuario);
            $objUsuario        = $em->getRepository('AppBundle:InfoUsuario')->findOneBy($arrayParametrosUs);
            if(!is_object($objUsuario) || empty($objUsuario))
            {
                throw new \Exception('No existe el usuario con la descripción enviada por parámetro.');
            }
            $arrayParametrosPerfil = array('ESTADO'      => 'ACTIVO',
                                           'DESCRIPCION' => $strDescripcion);
            $objPerfil             = $em->getRepository('AppBundle:InfoPerfil')->findOneBy($arrayParametrosPerfil);
            if(is_object($objPerfil) && !empty($objPerfil))
            {
                throw new \Exception('Perfil ya existente.');
            }
            $entityPerfil = new InfoPerfil();
            $entityPerfil->setMODULOID($objModulo);
            $entityPerfil->setACCIONID($objAccion);
            $entityPerfil->setUSUARIOID($objUsuario);
            $entityPerfil->setDESCRIPCION($strDescripcion);
            $entityPerfil->setESTADO(strtoupper($strEstado));
            $entityPerfil->setUSRCREACION($strUsuarioCreacion);
            $entityPerfil->setFECREACION($strDatetimeActual);
            $em->persist($entityPerfil);
            $em->flush();
            $strMensajeError = 'Perfil creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al crear un Perfil, intente nuevamente.\n ". $ex->getMessage();
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
     * @Route("/editPerfil")
     *
     * Documentación para la función 'editPerfil'
     * Método encargado de editar los perfiles según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 10-09-2019
     * 
     * @return array  $objResponse
     */
    public function editPerfilAction(Request $request)
    {
        $intIdPerfil            = $request->query->get("idPerfil") ? $request->query->get("idPerfil"):'';
        $intIdModulo            = $request->query->get("idModulo") ? $request->query->get("idModulo"):'';
        $intIdAccion            = $request->query->get("idAccion") ? $request->query->get("idAccion"):'';
        $intIdUsuario           = $request->query->get("idUsuario") ? $request->query->get("idUsuario"):'';
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
            $objPerfil = $em->getRepository('AppBundle:InfoPerfil')->findOneBy(array('id'=>$intIdPerfil));
            if(!is_object($objPerfil) || empty($objPerfil))
            {
                throw new \Exception('No existe Perfil con la descripción enviada por parámetro.');
            }
            if(!empty($intIdModulo))
            {
                $arrayParametrosModulo = array('ESTADO' => 'ACTIVO',
                                               'id'     => $intIdModulo);
                $objModulo             = $em->getRepository('AppBundle:AdmiModulo')->findOneBy($arrayParametrosModulo);
                if(!is_object($objModulo) || empty($objModulo))
                {
                    throw new \Exception('No existe el módulo con la descripción enviada por parámetro.');
                }
                $objPerfil->setMODULOID($objModulo);
            }
            if(!empty($intIdAccion))
            {
                $arrayParametrosAccion = array('ESTADO' => 'ACTIVO',
                                               'id'     => $intIdAccion);
                $objAccion             = $em->getRepository('AppBundle:AdmiAccion')->findOneBy($arrayParametrosAccion);
                if(!is_object($objAccion) || empty($objAccion))
                {
                    throw new \Exception('No existe el acción con la descripción enviada por parámetro.');
                }
                $objPerfil->setACCIONID($objAccion);
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
                $objPerfil->setUSUARIOID($objUsuario);
            }

            if(!empty($strDescripcion))
            {
                $objPerfil->setDESCRIPCION($strDescripcion);
            }
            if(!empty($strEstado))
            {
                $objPerfil->setESTADO(strtoupper($strEstado));
            }
            $objPerfil->setUSRMODIFICACION($strUsuarioCreacion);
            $objPerfil->setFEMODIFICACION($strDatetimeActual);
            $em->persist($objPerfil);
            $em->flush();
            $strMensajeError = 'Perfil editado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            
            $strMensajeError = "Fallo al editar un Perfil, intente nuevamente.\n ". $ex->getMessage();
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
     * @Route("/getPerfil")
     *
     * Documentación para la función 'getPerfil'
     * Método encargado de retornar todos los perfiles según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 10-09-2019
     * 
     * @return array  $objResponse
     */
    public function getPerfilAction(Request $request)
    {
        $intIdPerfil            = $request->query->get("idPerfil") ? $request->query->get("idPerfil"):'';
        $intIdModulo            = $request->query->get("idModulo") ? $request->query->get("idModulo"):'';
        $intIdAccion            = $request->query->get("idAccion") ? $request->query->get("idAccion"):'';
        $intIdUsuario           = $request->query->get("idUsuario") ? $request->query->get("idUsuario"):'';
        $strDescripcion         = $request->query->get("descripcion") ? $request->query->get("descripcion"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $arrayPerfil          = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        try
        {
            $arrayParametros = array('intIdPerfil'   => $intIdPerfil,
                                    'intIdModulo'    => $intIdModulo,
                                    'intIdAccion'    => $intIdAccion,
                                    'intIdUsuario'   => $intIdUsuario,
                                    'strDescripcion' => $strDescripcion,
                                    'strEstado'      => $strEstado
                                    );
            $arrayPerfil   = $this->getDoctrine()->getRepository('AppBundle:InfoPerfil')->getPerfilCriterio($arrayParametros);
            if(isset($arrayPerfil['error']) && !empty($arrayPerfil['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayPerfil['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayPerfil['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayPerfil,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * @Route("/deletePerfil")
     *
     * Documentación para la función 'deletePerfil'
     * Método encargado de eliminar los perfiles según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 10-09-2019
     * 
     * @return array  $objResponse
     */
    public function deletePerfilAction(Request $request)
    {
        $intIdPerfil            = $request->query->get("idPerfil") ? $request->query->get("idPerfil"):'';
        $intIdModulo            = $request->query->get("idModulo") ? $request->query->get("idModulo"):'';
        $intIdAccion            = $request->query->get("idAccion") ? $request->query->get("idAccion"):'';
        $intIdUsuario           = $request->query->get("idUsuario") ? $request->query->get("idUsuario"):'';
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
            if(!empty($intIdModulo))
            {
                $arrayParametrosModulo = array('id' => $intIdModulo);
                $objModulo             = $em->getRepository('AppBundle:AdmiModulo')->findOneBy($arrayParametrosModulo);
                if(!is_object($objModulo) || empty($objModulo))
                {
                    throw new \Exception('No existe el módulo con la descripción enviada por parámetro.');
                }
            }
            if(!empty($intIdAccion))
            {
                $arrayParametrosAccion = array('id' => $intIdAccion);
                $objAccion             = $em->getRepository('AppBundle:AdmiAccion')->findOneBy($arrayParametrosAccion);
                if(!is_object($objAccion) || empty($objAccion))
                {
                    throw new \Exception('No existe el acción con la descripción enviada por parámetro.');
                }
            }
            if(!empty($intIdUsuario))
            {
                $arrayParametrosUs = array('id' => $intIdUsuario);
                $objUsuario        = $em->getRepository('AppBundle:InfoUsuario')->findOneBy($arrayParametrosUs);
                if(!is_object($objUsuario) || empty($objUsuario))
                {
                    throw new \Exception('No existe el usuario con la descripción enviada por parámetro.');
                }
            }
            $arrayParametrosPerfil = array ('MODULO_ID'  => $intIdModulo,
                                            'ACCION_ID'  => $intIdAccion,
                                            'USUARIO_ID' => $intIdUsuario);
            $objPerfil = $em->getRepository('AppBundle:InfoPerfil')->findOneBy($arrayParametrosPerfil);
            if(!is_object($objPerfil) || empty($objPerfil))
            {
                throw new \Exception('No existe Perfil con la descripción enviada por parámetro.');
            }
            $em->remove($objPerfil);
            $em->flush();
            $strMensajeError = 'Perfil eliminado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            
            $strMensajeError = "Fallo al eliminar un Perfil, intente nuevamente.\n ". $ex->getMessage();
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
