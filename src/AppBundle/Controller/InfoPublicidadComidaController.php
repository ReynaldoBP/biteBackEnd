<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoPublicidad;
use AppBundle\Entity\AdmiTipoComida;
use AppBundle\Entity\InfoPublicidadComida;

class InfoPublicidadComidaController extends Controller
{
    /**
     * @Route("/createPublicidadComida")
     *
     * Documentación para la función 'createPublicidadComida'
     * Método encargado de crear las relaciones entre tipo de comida y publicidad 
     * según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 15-09-2019
     * 
     * @return array  $objResponse
     */
    public function createPublicidadComidaAction(Request $request)
    {
        $intIdTipoComida        = $request->query->get("idTipoComida") ? $request->query->get("idTipoComida"):'';
        $intIdPublicidad        = $request->query->get("idPublicidad") ? $request->query->get("idPublicidad"):'';
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
            $arrayParametrosPublicidad = array('ESTADO' => 'ACTIVO',
                                               'id'     => $intIdPublicidad);
            $objPublicidad             = $em->getRepository('AppBundle:InfoPublicidad')->findOneBy($arrayParametrosPublicidad);
            if(!is_object($objPublicidad) || empty($objPublicidad))
            {
                throw new \Exception('No existe la publicidad con la descripción enviada por parámetro.');
            }
            $arrayParametrosTC = array('ESTADO' => 'ACTIVO',
                                       'id'     => $intIdTipoComida);
            $objTipoCom        = $em->getRepository('AppBundle:AdmiTipoComida')->findOneBy($arrayParametrosTC);
            if(!is_object($objTipoCom) || empty($objTipoCom))
            {
                throw new \Exception('No existe el usuario con la descripción enviada por parámetro.');
            }
            $arrayParametrosRelacion = array('ESTADO'        => 'ACTIVO',
                                             'TIPO_COMIDAID' => $intIdTipoComida,
                                             'PUBLICIDADID'  => $intIdPublicidad);
            $objPubComida           = $em->getRepository('AppBundle:InfoPublicidadComida')->findOneBy($arrayParametrosRelacion);
            if(is_object($objPubComida) && !empty($objPubComida))
            {
                throw new \Exception('Relación ya existente.');
            }
            $entityPublicidadComida = new InfoPublicidadComida();
            $entityPublicidadComida->setPUBLICIDADID($objPublicidad);
            $entityPublicidadComida->setTIPOCOMIDAID($objTipoCom);
            $entityPublicidadComida->setESTADO(strtoupper($strEstado));
            $entityPublicidadComida->setUSRCREACION($strUsuarioCreacion);
            $entityPublicidadComida->setFECREACION($strDatetimeActual);
            $em->persist($entityPublicidadComida);
            $em->flush();
            $strMensajeError = 'Relación entre Publicidad y Tipo de comida creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al crear una Relación entre Publicidad y Tipo de comida, intente nuevamente.\n ". $ex->getMessage();
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
     * @Route("/editPublicidadComida")
     *
     * Documentación para la función 'editPublicidadComida'
     * Método encargado de editar las relaciones entre tipo de comida y publicidad 
     * según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 15-09-2019
     * 
     * @return array  $objResponse
     */
    public function editPublicidadComidaAction(Request $request)
    {
        $intIdPubComida         = $request->query->get("idPubComida") ? $request->query->get("idPubComida"):'';
        $intIdTipoComida        = $request->query->get("idTipoComida") ? $request->query->get("idTipoComida"):'';
        $intIdPublicidad        = $request->query->get("idPublicidad") ? $request->query->get("idPublicidad"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $objPubComida = $em->getRepository('AppBundle:InfoPublicidadComida')->findOneBy(array('id'=>$intIdPubComida));
            if(!is_object($objPubComida) || empty($objPubComida))
            {
                throw new \Exception('No existe una Relación entre Publicidad y Tipo de comida con la descripción enviada por parámetro.');
            }
            if(!empty($intIdTipoComida))
            {
                $arrayParametrosTC    = array('ESTADO' => 'ACTIVO',
                                              'id'     => $intIdTipoComida);
                $objTipoComida        = $em->getRepository('AppBundle:AdmiTipoComida')->findOneBy($arrayParametrosTC);
                if(!is_object($objTipoComida) || empty($objTipoComida))
                {
                    throw new \Exception('No existe el tipo de comida con la descripción enviada por parámetro.');
                }
                $objPubComida->setTIPOCOMIDAID($objTipoComida);
            }
            if(!empty($intIdPublicidad))
            {
                $arrayParametrosPub = array('ESTADO' => 'ACTIVO',
                                            'id'     => $intIdPublicidad);
                $objPublicidad      = $em->getRepository('AppBundle:InfoPublicidad')->findOneBy($arrayParametrosPub);
                if(!is_object($objPublicidad) || empty($objPublicidad))
                {
                    throw new \Exception('No existe la publicidad con la descripción enviada por parámetro.');
                }
                $objPubComida->setPUBLICIDADID($objPublicidad);
            }

            if(!empty($strEstado))
            {
                $objPubComida->setESTADO(strtoupper($strEstado));
            }
            $objPubComida->setUSRMODIFICACION($strUsuarioCreacion);
            $objPubComida->setFEMODIFICACION($strDatetimeActual);
            $em->persist($objPubComida);
            $em->flush();
            $strMensajeError = 'Relación entre Publicidad y Tipo de comida editado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            
            $strMensajeError = "Fallo al editar una Relación entre Publicidad y Tipo de comida, intente nuevamente.\n ". $ex->getMessage();
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
     * @Route("/getPublicidadComida")
     *
     * Documentación para la función 'getPublicidadComida'
     * Método encargado de retornar las relaciones entre tipo de comida y publicidad 
     * según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 15-09-2019
     * 
     * @return array  $objResponse
     */
    public function getPublicidadComidaAction(Request $request)
    {
        $intIdPubComida         = $request->query->get("idPubComida") ? $request->query->get("idPubComida"):'';
        $intIdTipoComida        = $request->query->get("idTipoComida") ? $request->query->get("idTipoComida"):'';
        $intIdPublicidad        = $request->query->get("idPublicidad") ? $request->query->get("idPublicidad"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $arrayPubliCom          = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        try
        {
            $arrayParametros = array('intIdPubComida'  => $intIdPubComida,
                                     'intIdTipoComida' => $intIdTipoComida,
                                     'intIdPublicidad' => $intIdPublicidad,
                                     'strEstado'       => $strEstado
                                    );
            $arrayPubliCom = $this->getDoctrine()->getRepository('AppBundle:InfoPublicidadComida')->getRelacionPubComCriterio($arrayParametros);
            if(isset($arrayPubliCom['error']) && !empty($arrayPubliCom['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayPubliCom['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayPubliCom['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayPubliCom,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * @Route("/deletePublicidadComida")
     *
     * Documentación para la función 'deletePublicidadComida'
     * Método encargado de eliminar las relaciones entre tipo de comida y publicidad 
     * según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 15-09-2019
     * 
     * @return array  $objResponse
     */
    public function deletePublicidadComidaAction(Request $request)
    {
        $intIdPubComida         = $request->query->get("idPubComida") ? $request->query->get("idPubComida"):'';
        $intIdPublicidad        = $request->query->get("idPublicidad") ? $request->query->get("idPublicidad"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            if(!empty($intIdPublicidad))
            {
                $arrayParametrosPub = array('ESTADO' => 'ACTIVO',
                                            'id'     => $intIdPublicidad);
                $objPublicidad      = $em->getRepository('AppBundle:InfoPublicidad')->findOneBy($arrayParametrosPub);
                if(!is_object($objPublicidad) || empty($objPublicidad))
                {
                    throw new \Exception('No existe la publicidad con la descripción enviada por parámetro.');
                }
            }
            $arrayParametrosPubComida = array('PUBLICIDADID'  => $intIdPublicidad);
            $objPubComida             = $em->getRepository('AppBundle:InfoPublicidadComida')->findBy($arrayParametrosPubComida);
            if(empty($objPubComida))
            {
                throw new \Exception('No existe una Relación entre Publicidad y Tipo de comida con la descripción enviada por parámetro.');
            }
            foreach($objPubComida as $item)
            {
                $em->remove($item);
            }
            $em->flush();
            $strMensajeError = 'Relación entre Publicidad y Tipo de comida eliminado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            
            $strMensajeError = "Fallo al eliminar una Relación entre Publicidad y Tipo de comida, intente nuevamente.\n ". $ex->getMessage();
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
