<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoPromocion;
use AppBundle\Entity\InfoSucursal;
use AppBundle\Controller\DefaultController;
class InfoPromocionController extends Controller
{
    /**
     * @Route("/createPromocion")
     *
     * Documentación para la función 'createPromocion'
     * Método encargado de crear las promociones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 05-09-2019
     * 
     * @return array  $objResponse
     */
    public function createPromocionAction(Request $request)
    {
        $intIdSucursal          = $request->query->get("idSucursal") ? $request->query->get("idSucursal"):'';
        $strDescrPromocion      = $request->query->get("descrPromocion") ? $request->query->get("descrPromocion"):'';
        $intCantPuntos          = $request->query->get("cantPuntos") ? $request->query->get("cantPuntos"):'';
        $strAceptaGlobal        = $request->query->get("aceptaGlobal") ? $request->query->get("aceptaGlobal"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
        $strPremio              = $request->query->get("premio") ? $request->query->get("premio"):'NO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        $strDescripcion='';
        try
        {
            $em->getConnection()->beginTransaction();
            $arrayParametros = array('ESTADO' => 'ACTIVO',
                                     'id'     => $intIdSucursal);
            $objSucursal     = $em->getRepository('AppBundle:InfoSucursal')->findOneBy($arrayParametros);
            if(!is_object($objSucursal) || empty($objSucursal))
            {
                throw new \Exception('No existe la sucursal con la descripción enviada por parámetro.');
            }
            $entityPromocion = new InfoPromocion();
            $entityPromocion->setSUCURSALID($objSucursal);
            $entityPromocion->setDESCRIPCIONTIPOPROMOCION($strDescrPromocion);
            $entityPromocion->setCANTIDADPUNTOS($intCantPuntos);
            $entityPromocion->setACEPTAGLOBAL($strAceptaGlobal);
            $entityPromocion->setPREMIO($strPremio);
            $entityPromocion->setESTADO(strtoupper($strEstado));
            $entityPromocion->setUSRCREACION($strUsuarioCreacion);
            $entityPromocion->setFECREACION($strDatetimeActual);
            $em->persist($entityPromocion);
            $em->flush();
            $strMensajeError = 'Promoción creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al crear una Promoción, intente nuevamente.\n ". $ex->getMessage();
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
     * @Route("/editPromocion")
     *
     * Documentación para la función 'editPromocion'
     * Método encargado de editar las promociones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 05-09-2019
     * 
     * @return array  $objResponse
     */
    public function editPromocionAction(Request $request)
    {
        $intIdPromocion         = $request->query->get("idPromocion") ? $request->query->get("idPromocion"):'';
        $intIdSucursal          = $request->query->get("idSucursal") ? $request->query->get("idSucursal"):'';
        $strDescrPromocion      = $request->query->get("descrPromocion") ? $request->query->get("descrPromocion"):'';
        $intCantPuntos          = $request->query->get("cantPuntos") ? $request->query->get("cantPuntos"):'';
        $strAceptaGlobal        = $request->query->get("aceptaGlobal") ? $request->query->get("aceptaGlobal"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $strPremio              = $request->query->get("premio") ? $request->query->get("premio"):'NO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        $strDescripcion='';
        try
        {
            $em->getConnection()->beginTransaction();
            $objPromocion = $em->getRepository('AppBundle:InfoPromocion')->findOneBy(array('id'=>$intIdPromocion));
            if(!is_object($objPromocion) || empty($objPromocion))
            {
                throw new \Exception('No existe promoción con la identificación enviada por parámetro.');
            }
            if(!empty($intIdSucursal))
            {
                $arrayParametros = array('ESTADO' => $strEstado,
                                         'id'     => $intIdSucursal);
                $objSucursal     = $em->getRepository('AppBundle:InfoSucursal')->findOneBy($arrayParametros);
                if(!is_object($objSucursal) || empty($objSucursal))
                {
                    throw new \Exception('No existe sucursal con la descripción enviada por parámetro.');
                }
                $objPromocion->setSUCURSALID($objSucursal);
            }
            if(!empty($strDescrPromocion))
            {
                $objPromocion->setDESCRIPCIONTIPOPROMOCION($strDescrPromocion);
            }
            if(!empty($strPremio))
            {
                $objPromocion->setPREMIO($strPremio);
            }
            if(!empty($intCantPuntos))
            {
                $objPromocion->setCANTIDADPUNTOS($intCantPuntos);
            }
            if(!empty($strAceptaGlobal))
            {
                $objPromocion->setACEPTAGLOBAL($strAceptaGlobal);
            }
            if(!empty($strEstado))
            {
                $objPromocion->setESTADO(strtoupper($strEstado));
            }
            $objPromocion->setUSRMODIFICACION($strUsuarioCreacion);
            $objPromocion->setFEMODIFICACION($strDatetimeActual);
            $em->persist($objPromocion);
            $em->flush();
            $strMensajeError = 'Promoción editado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            
            $strMensajeError = "Fallo al editar un Promoción, intente nuevamente.\n ". $ex->getMessage();
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
     * @Route("/getPromocion")
     *
     * Documentación para la función 'getPromocion'
     * Método encargado de retornar todos las promociones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 05-09-2019
     * 
     * @return array  $objResponse
     */
    public function getPromocionAction(Request $request)
    {
        $intIdPromocion         = $request->query->get("idPromocion") ? $request->query->get("idPromocion"):'';
        $intIdSucursal          = $request->query->get("idSucursal") ? $request->query->get("idSucursal"):'';
        $strDescrPromocion      = $request->query->get("descrPromocion") ? $request->query->get("descrPromocion"):'';
        $strPromo               = $request->query->get("strPromo") ? $request->query->get("strPromo"):'NO';
        $strMes                 = $request->query->get("strMes") ? $request->query->get("strMes"):'';
        $strAnio                = $request->query->get("strAnio") ? $request->query->get("strAnio"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $conImagen              = $request->query->get("imagen") ? $request->query->get("imagen"):'NO';
        $arrayPromocion          = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        try
        {
            $objController   = new DefaultController();
            $objController->setContainer($this->container);
            $arrayParametros = array('intIdPromocion'   => $intIdPromocion,
                                    'intIdSucursal'     => $intIdSucursal,
                                    'strDescrPromocion' => $strDescrPromocion,
                                    'strPromo'          => $strPromo,
                                    'strMes'            => $strMes,
                                    'strAnio'           => $strAnio,
                                    'strEstado'         => $strEstado);
            $arrayPromocion   = (array) $this->getDoctrine()->getRepository('AppBundle:InfoPromocion')->getPromocionCriterio($arrayParametros);
            if(isset($arrayPromocion['error']) && !empty($arrayPromocion['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayPromocion['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayPromocion['error'] = $strMensajeError;
        if($conImagen == 'SI')
        {
            foreach ($arrayPromocion['resultados'] as &$item)
            {
                if($item['IMAGEN'])
                {
                    $item['IMAGEN'] = $objController->getImgBase64($item['IMAGEN']);
                }
            }
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayPromocion,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

}
