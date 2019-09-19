<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\AdmiTipoComida;
use AppBundle\Entity\InfoPublicidad;
use AppBundle\Controller\DefaultController;
class InfoPublicidadController extends Controller
{
    /**
     * @Route("/createPublicidad")
     *
     * Documentación para la función 'createPublicidad'
     * Método encargado de crear las publicaciones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 05-09-2019
     * 
     * @return array  $objResponse
     */
    public function createPublicidadAction(Request $request)
    {
        $strDescrPublicidad     = $request->query->get("descrPublicidad") ? $request->query->get("descrPublicidad"):'';
        $strImagen              = $request->query->get("imagen") ? $request->query->get("imagen"):'';
        $strOrientacion         = $request->query->get("orientacion") ? $request->query->get("orientacion"):'';
        $strEdadMaxima          = $request->query->get("edadMaxima") ? $request->query->get("edadMaxima"):'';
        $strEdadMinima          = $request->query->get("edadMinima") ? $request->query->get("edadMinima"):'';
        $strGenero              = $request->query->get("genero") ? $request->query->get("genero"):'';
        $strPais                = $request->query->get("pais") ? $request->query->get("pais"):'';
        $strProvincia           = $request->query->get("provincia") ? $request->query->get("provincia"):'';
        $strCiudad              = $request->query->get("ciudad") ? $request->query->get("ciudad"):'';
        $strParroquia           = $request->query->get("parroquia") ? $request->query->get("parroquia"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'ACTIVO';
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
            if(!is_object($objTipoComida) || empty($objTipoComida))
            {
                throw new \Exception('No existe el tipo de comida con la descripción enviada por parámetro.');
            }
            $entityPublicidad = new InfoPublicidad();
            $entityPublicidad->setDESCRIPCION($strDescrPublicidad);
            $entityPublicidad->setIMAGEN($strImagen);
            $entityPublicidad->setORIENTACION($strOrientacion);
            $entityPublicidad->setEDADMAXIMA($strEdadMaxima);
            $entityPublicidad->setEDADMINIMA($strEdadMinima);
            $entityPublicidad->setGENERO($strGenero);
            $entityPublicidad->setPAIS($strPais);
            $entityPublicidad->setPROVINCIA($strProvincia);
            $entityPublicidad->setCIUDAD($strCiudad);
            $entityPublicidad->setPARROQUIA($strParroquia);
            $entityPublicidad->setESTADO(strtoupper($strEstado));
            $entityPublicidad->setUSRCREACION($strUsuarioCreacion);
            $entityPublicidad->setFECREACION($strDatetimeActual);
            $em->persist($entityPublicidad);
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
     * @Route("/editPublicidad")
     *
     * Documentación para la función 'editPublicidad'
     * Método encargado de editar las publicaciones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 05-09-2019
     * 
     * @return array  $objResponse
     */
    public function editPublicidadAction(Request $request)
    {
        $intIdPublicidad        = $request->query->get("idPublicidad") ? $request->query->get("idPublicidad"):'';
        $strDescrPublicidad     = $request->query->get("descrPublicidad") ? $request->query->get("descrPublicidad"):'';
        $strImagen              = $request->query->get("imagen") ? $request->query->get("imagen"):'';
        $strOrientacion         = $request->query->get("orientacion") ? $request->query->get("orientacion"):'';
        $strEdadMaxima          = $request->query->get("edadMaxima") ? $request->query->get("edadMaxima"):'';
        $strEdadMinima          = $request->query->get("edadMinima") ? $request->query->get("edadMinima"):'';
        $strGenero              = $request->query->get("genero") ? $request->query->get("genero"):'';
        $strPais                = $request->query->get("pais") ? $request->query->get("pais"):'';
        $strProvincia           = $request->query->get("provincia") ? $request->query->get("provincia"):'';
        $strCiudad              = $request->query->get("ciudad") ? $request->query->get("ciudad"):'';
        $strParroquia           = $request->query->get("parroquia") ? $request->query->get("parroquia"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
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
            $objPublicidad = $em->getRepository('AppBundle:InfoPublicidad')->findOneBy(array('id'=>$intIdPublicidad));
            if(!is_object($objPublicidad) || empty($objPublicidad))
            {
                throw new \Exception('No existe publicidad con la identificación enviada por parámetro.');
            }
            if(!empty($strDescrPublicidad))
            {
                $objPublicidad->setDESCRIPCION($strDescrPublicidad);
            }
            if(!empty($strImagen))
            {
                $objPublicidad->setIMAGEN($strImagen);
            }
            if(!empty($strOrientacion))
            {
                $objPublicidad->setORIENTACION($strOrientacion);
            }
            if(!empty($strEdadMaxima))
            {
                $objPublicidad->setEDADMAXIMA($strEdadMaxima);
            }
            if(!empty($strEdadMinima))
            {
                $objPublicidad->setEDADMINIMA($strEdadMinima);
            }
            if(!empty($strGenero))
            {
                $objPublicidad->setGENERO($strGenero);
            }
            if(!empty($strPais))
            {
                $objPublicidad->setPAIS($strPais);
            }
            if(!empty($strProvincia))
            {
                $objPublicidad->setPROVINCIA($strProvincia);
            }
            if(!empty($strCiudad))
            {
                $objPublicidad->setCIUDAD($strCiudad);
            }
            if(!empty($strParroquia))
            {
                $objPublicidad->setPARROQUIA($strParroquia);
            }
            if(!empty($strEstado))
            {
                $objPublicidad->setESTADO(strtoupper($strEstado));
            }
            $objPublicidad->setUSRMODIFICACION($strUsuarioCreacion);
            $objPublicidad->setFEMODIFICACION($strDatetimeActual);
            $em->persist($objPublicidad);
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
     * @Route("/getPublicidad")
     *
     * Documentación para la función 'getPublicidad'
     * Método encargado de retornar todos las publicaciones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 05-09-2019
     * 
     * @return array  $objResponse
     */
    public function getPublicidadAction(Request $request)
    {
        $intIdPublicidad        = $request->query->get("idPublicidad") ? $request->query->get("idPublicidad"):'';
        $strDescrPublicidad     = $request->query->get("descrPublicidad") ? $request->query->get("descrPublicidad"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $conImagen              = $request->query->get("imagen") ? $request->query->get("imagen"):'NO';
        $arrayPublicidad          = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        try
        {
            $objController    = new DefaultController();
            $objController->setContainer($this->container);
            $arrayParametros = array('intIdPublicidad'   => $intIdPublicidad,
                                    'strDescrPublicidad' => $strDescrPublicidad,
                                    'strEstado'          => $strEstado);
            $arrayPublicidad = (array) $this->getDoctrine()->getRepository('AppBundle:InfoPublicidad')->getPublicidadCriterio($arrayParametros);
            if(isset($arrayPublicidad['error']) && !empty($arrayPublicidad['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayPublicidad['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayPublicidad['error'] = $strMensajeError;
        if($conImagen == 'SI')
        {
            foreach ($arrayPublicidad['resultados'] as &$item)
            {
                if($item['IMAGEN'])
                {
                    $item['IMAGEN'] = $objController->getImgBase64($item['IMAGEN']);
                }
            }
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayPublicidad,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

}
