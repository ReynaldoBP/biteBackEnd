<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoRestaurante;
use AppBundle\Entity\AdmiTipoComida;
use AppBundle\Controller\DefaultController;
use AppBundle\Entity\InfoPublicidad;
use AppBundle\Entity\InfoPromocion;
use AppBundle\Entity\InfoSucursal;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
class ApiWebController extends FOSRestController
{
    /**
     * @Rest\Post("/webBitte/procesar")
     */
    public function postAction(Request $request)
    {
        $strOperacion = $request->get('op');
        $arrayRequest = json_decode($request->getContent(),true);
        $arrayData    = $arrayRequest['data'];
        $objResponse  = new Response;
        if($strOperacion)
        {
            switch($strOperacion)
            {
                case 'createRestaurante':$arrayRespuesta = $this->createRestaurante($arrayData);
                break;
                case 'editRestaurante':$arrayRespuesta = $this->editRestaurante($arrayData);
                break;
                case 'createPublicidad':$arrayRespuesta = $this->createPublicidad($arrayData);
                break;
                case 'editPublicidad':$arrayRespuesta = $this->editPublicidad($arrayData);
                break;
                case 'createPromocion':$arrayRespuesta = $this->createPromocion($arrayData);
                break;
                case 'editPromocion':$arrayRespuesta = $this->editPromocion($arrayData);
                break;
                 $objResponse->setContent(json_encode(array(
                                                     'status'    => 400,
                                                     'resultado' => "No existe método con la descripción enviado por parámetro",
                                                     'succes'    => true
                                                     )
                                                 ));
                 $objResponse->headers->set('Access-Control-Allow-Origin', '*');
                 $arrayRespuesta = $objResponse;
             }
         }
        return $arrayRespuesta;
    }
    /**
     * Documentación para la función 'createRestaurante'
     * Método encargado de crear los restaurantes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 09-09-2019
     * 
     * @return array  $objResponse
     */
    public function createRestaurante($arrayData)
    {
        $strTipoComida          = $arrayData['tipoComida'] ? $arrayData['tipoComida']:'';
        $strIdTipoComida        = $arrayData['idTipoComida'] ? $arrayData['idTipoComida']:'';
        $strTipoIdentificacion  = $arrayData['tipoIdentificacion'] ? $arrayData['tipoIdentificacion']:'';
        $strIdentificacion      = $arrayData['identificacion'] ? $arrayData['identificacion']:'';
        $strRazonSocial         = $arrayData['razonSocial'] ? $arrayData['razonSocial']:'';
        $strNombreComercial     = $arrayData['nombreComercial'] ? $arrayData['nombreComercial']:'';
        $strRepresentanteLegal  = $arrayData['representanteLegal'] ? $arrayData['representanteLegal']:'';
        $strDireccionTributario = $arrayData['direcion'] ? $arrayData['direcion']:'';
        $strUrlCatalogo         = $arrayData['urlCatalogo'] ? $arrayData['urlCatalogo']:'';
        $strNumeroContacto      = $arrayData['numeroContacto'] ? $arrayData['numeroContacto']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $imgBase64              = $arrayData['rutaImagen'] ? $arrayData['rutaImagen']:'';
        $icoBase64              = $arrayData['rutaIcono'] ? $arrayData['rutaIcono']:'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        $objController          = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            if(!empty($imgBase64))
            {
                $strRutaImagen = $objController->subirfichero($imgBase64);
            }
            if(!empty($icoBase64))
            {
                $strRutaIcono  = $objController->subirfichero($icoBase64);
            }
            $em->getConnection()->beginTransaction();
            if(strtoupper($strTipoIdentificacion) == 'RUC' && strlen(trim($strIdentificacion))!=13)
            {
                throw new \Exception('cantidad de dígitos incorrecto');
            }
            elseif(strtoupper($strTipoIdentificacion) == 'CED' && strlen(trim($strIdentificacion))!=10)
            {
                throw new \Exception('cantidad de dígitos incorrecto');
            }
            $objTipoComida = $em->getRepository('AppBundle:AdmiTipoComida')->find($strIdTipoComida);
            if(!is_object($objTipoComida) || empty($objTipoComida))
            {
                $objTipoComida = $em->getRepository('AppBundle:AdmiTipoComida')->findOneBy(array('DESCRIPCION'=>$strTipoComida));
                if(!is_object($objTipoComida) || empty($objTipoComida))
                {
                    throw new \Exception('Tipo de comida no existe.');
                }
            }
            $objRestaurante = $em->getRepository('AppBundle:InfoRestaurante')->findOneBy(array('IDENTIFICACION'=>$strIdentificacion));
            if(is_object($objRestaurante) && !empty($objRestaurante))
            {
                throw new \Exception('Restaurante ya existente.');
            }
            $entityRestaurante = new InfoRestaurante();
            $entityRestaurante->setTIPOCOMIDAID($objTipoComida);
            $entityRestaurante->setTIPOIDENTIFICACION(strtoupper($strTipoIdentificacion));
            $entityRestaurante->setIDENTIFICACION($strIdentificacion);
            $entityRestaurante->setRAZONSOCIAL($strRazonSocial);
            $entityRestaurante->setNOMBRECOMERCIAL($strNombreComercial);
            $entityRestaurante->setREPRESENTANTELEGAL($strRepresentanteLegal);
            $entityRestaurante->setDIRECCIONTRIBUTARIO($strDireccionTributario);
            $entityRestaurante->setURLCATALOGO($strUrlCatalogo);
            $entityRestaurante->setIMAGEN($strRutaImagen);
            $entityRestaurante->setICONO($strRutaIcono);
            $entityRestaurante->setNUMEROCONTACTO($strNumeroContacto);
            $entityRestaurante->setESTADO(strtoupper($strEstado));
            $entityRestaurante->setUSRCREACION($strUsuarioCreacion);
            $entityRestaurante->setFECREACION($strDatetimeActual);
            $em->persist($entityRestaurante);
            $em->flush();
            $strMensajeError = 'Restaurante creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al crear un restaurante, intente nuevamente.\n ". $ex->getMessage();
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
     * Documentación para la función 'editRestaurante'
     * Método encargado de editar los restaurantes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function editRestaurante($arrayData)
    {
        $strIdTipoComida        = $arrayData['idTipoComida'] ? $arrayData['idTipoComida']:'';
        $strTipoIdentificacion  = $arrayData['tipoIdentificacion'] ? $arrayData['tipoIdentificacion']:'';
        $strIdentificacion      = $arrayData['identificacion'] ? $arrayData['identificacion']:'';
        $strIdRestaurante       = $arrayData['idRestaurante'] ? $arrayData['idRestaurante']:'';
        $strRazonSocial         = $arrayData['razonSocial'] ? $arrayData['razonSocial']:'';
        $strNombreComercial     = $arrayData['nombreComercial'] ? $arrayData['nombreComercial']:'';
        $strRepresentanteLegal  = $arrayData['representanteLegal'] ? $arrayData['representanteLegal']:'';
        $strDireccionTributario = $arrayData['direcion'] ? $arrayData['direcion']:'';
        $strUrlCatalogo         = $arrayData['urlCatalogo'] ? $arrayData['urlCatalogo']:'';
        $strNumeroContacto      = $arrayData['numeroContacto'] ? $arrayData['numeroContacto']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $imgBase64              = $arrayData['rutaImagen'] ? $arrayData['rutaImagen']:'';
        $icoBase64              = $arrayData['rutaIcono'] ? $arrayData['rutaIcono']:'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        $objController          = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            if(!empty($imgBase64))
            {
                $strRutaImagen = $objController->subirfichero($imgBase64);
            }
            if(!empty($icoBase64))
            {
                $strRutaIcono = $objController->subirfichero($icoBase64);
            }

            $em->getConnection()->beginTransaction();
            if(strtoupper($strTipoIdentificacion) == 'RUC' && strlen(trim($strIdentificacion))!=13)
            {
                throw new \Exception('cantidad de dígitos incorrecto');
            }
            elseif(strtoupper($strTipoIdentificacion) == 'CED' && strlen(trim($strIdentificacion))!=10)
            {
                throw new \Exception('cantidad de dígitos incorrecto');
            }
            $objRestaurante = $em->getRepository('AppBundle:InfoRestaurante')->find($strIdRestaurante);
            if(!is_object($objRestaurante) || empty($objRestaurante))
            {
                $objRestaurante = $em->getRepository('AppBundle:InfoRestaurante')->findOneBy(array('IDENTIFICACION'=>$strIdentificacion));
                if(!is_object($objRestaurante) || empty($objRestaurante))
                {
                    throw new \Exception('Restaurante no existe.');
                }
            }
            if(!empty($strIdTipoComida))
            {
                $objTipoComida = $em->getRepository('AppBundle:AdmiTipoComida')->find($strIdTipoComida);
                if(!is_object($objTipoComida) || empty($objTipoComida))
                {
                    throw new \Exception('Tipo de comida no existe.');
                }
                $objRestaurante->setTIPOCOMIDAID($objTipoComida);
            }
            if(!empty($strTipoIdentificacion))
            {
                $objRestaurante->setTIPOIDENTIFICACION(strtoupper($strTipoIdentificacion));
            }
            if(!empty($strIdentificacion))
            {
                $objRestaurante->setIDENTIFICACION($strIdentificacion);
            }
            if(!empty($strRazonSocial))
            {
                $objRestaurante->setRAZONSOCIAL($strRazonSocial);
            }
            if(!empty($strNombreComercial))
            {
                $objRestaurante->setNOMBRECOMERCIAL($strNombreComercial);
            }
            if(!empty($strRepresentanteLegal))
            {
                $objRestaurante->setREPRESENTANTELEGAL($strRepresentanteLegal);
            }
            if(!empty($strDireccionTributario))
            {
                $objRestaurante->setDIRECCIONTRIBUTARIO($strDireccionTributario);
            }
            if(!empty($strUrlCatalogo))
            {
                $objRestaurante->setURLCATALOGO($strUrlCatalogo);
            }
            if(!empty($strNumeroContacto))
            {
                $objRestaurante->setNUMEROCONTACTO($strNumeroContacto);
            }
            if(!empty($strEstado))
            {
                $objRestaurante->setESTADO(strtoupper($strEstado));
            }
            if(!empty($strRutaImagen))
            {
                $objRestaurante->setIMAGEN($strRutaImagen);
            }
            if(!empty($strRutaIcono))
            {
                $objRestaurante->setICONO($strRutaIcono);
            }
            $objRestaurante->setUSRMODIFICACION($strUsuarioCreacion);
            $objRestaurante->setFEMODIFICACION($strDatetimeActual);
            $em->persist($objRestaurante);
            $em->flush();
            $strMensajeError = 'Restaurante editado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al crear un restaurante, intente nuevamente.\n ". $ex->getMessage();
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
     * Documentación para la función 'createPublicidad'
     * Método encargado de crear las publicidades según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 13-09-2019
     * 
     * @return array  $objResponse
     */
    public function createPublicidad($arrayData)
    {
        $intIdTipoComida        = $arrayData['idTipoComida'] ? $arrayData['idTipoComida']:'';
        $strDescrPublicidad     = $arrayData['descrPublicidad'] ? $arrayData['descrPublicidad']:'';
        $imgBase64              = $arrayData['rutaImagen'] ? $arrayData['rutaImagen']:'';
        $strEdadMaxima          = $arrayData['edadMaxima'] ? $arrayData['edadMaxima']:'';
        $strEdadMinima          = $arrayData['edadMinima'] ? $arrayData['edadMinima']:'';
        $strGenero              = $arrayData['genero'] ? $arrayData['genero']:'';
        $strPais                = $arrayData['pais'] ? $arrayData['pais']:'';
        $strProvincia           = $arrayData['provincia'] ? $arrayData['provincia']:'';
        $strCiudad              = $arrayData['ciudad'] ? $arrayData['ciudad']:'';
        $strParroquia           = $arrayData['parroquia'] ? $arrayData['parroquia']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        $objController          = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            $em->getConnection()->beginTransaction();
            if(!empty($imgBase64))
            {
                $strRutaImagen = $objController->subirfichero($imgBase64);
            }
            $arrayParametros = array('ESTADO' => 'ACTIVO',
                                     'id'     => $intIdTipoComida);
            $objTipoComida   = $em->getRepository('AppBundle:AdmiTipoComida')->findOneBy($arrayParametros);
            if(!is_object($objTipoComida) || empty($objTipoComida))
            {
                throw new \Exception('No existe el tipo de comida con la descripción enviada por parámetro.');
            }
            $entityPublicidad = new InfoPublicidad();
            $entityPublicidad->setTIPOCOMIDAID($objTipoComida);
            $entityPublicidad->setDESCRIPCION($strDescrPublicidad);
            $entityPublicidad->setIMAGEN($strRutaImagen);
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
            $strMensajeError = 'Publicidad creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al crear una Publicidad, intente nuevamente.\n ". $ex->getMessage();
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
     * Documentación para la función 'editPublicidad'
     * Método encargado de crear las publicidades según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 13-09-2019
     * 
     * @return array  $objResponse
     */
    public function editPublicidad($arrayData)
    {
        $intIdPublicidad        = $arrayData['idPublicidad'] ? $arrayData['idPublicidad']:'';
        $intIdTipoComida        = $arrayData['idTipoComida'] ? $arrayData['idTipoComida']:'';
        $strDescrPublicidad     = $arrayData['descrPublicidad'] ? $arrayData['descrPublicidad']:'';
        $imgBase64              = $arrayData['rutaImagen'] ? $arrayData['rutaImagen']:'';
        $strEdadMaxima          = $arrayData['edadMaxima'] ? $arrayData['edadMaxima']:'';
        $strEdadMinima          = $arrayData['edadMinima'] ? $arrayData['edadMinima']:'';
        $strGenero              = $arrayData['genero'] ? $arrayData['genero']:'';
        $strPais                = $arrayData['pais'] ? $arrayData['pais']:'';
        $strProvincia           = $arrayData['provincia'] ? $arrayData['provincia']:'';
        $strCiudad              = $arrayData['ciudad'] ? $arrayData['ciudad']:'';
        $strParroquia           = $arrayData['parroquia'] ? $arrayData['parroquia']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        $objController          = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            $em->getConnection()->beginTransaction();
            if(!empty($imgBase64))
            {
                $strRutaImagen = $objController->subirfichero($imgBase64);
            }
            $objPublicidad = $em->getRepository('AppBundle:InfoPublicidad')->findOneBy(array('id'=>$intIdPublicidad));
            if(!is_object($objPublicidad) || empty($objPublicidad))
            {
                throw new \Exception('No existe publicidad con la identificación enviada por parámetro.');
            }
            if(!empty($intIdTipoComida))
            {
                $arrayParametros = array('ESTADO' => 'ACTIVO',
                                        'id'     => $intIdTipoComida);
                $objTipoComida   = $em->getRepository('AppBundle:AdmiTipoComida')->findOneBy($arrayParametros);
                if(!is_object($objTipoComida) || empty($objTipoComida))
                {
                    throw new \Exception('No existe el tipo de comida con la descripción enviada por parámetro.');
                }
                $objPublicidad->setTIPOCOMIDAID($objTipoComida);
            }
            if(!empty($strDescrPublicidad))
            {
                $objPublicidad->setDESCRIPCION($strDescrPublicidad);
            }
            if(!empty($strRutaImagen))
            {
                $objPublicidad->setIMAGEN($strRutaImagen);
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
            $strMensajeError = 'Publicidad editado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            
            $strMensajeError = "Fallo al editar un Publicidad, intente nuevamente.\n ". $ex->getMessage();
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
     * Documentación para la función 'createPromocion'
     * Método encargado de crear las promociones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 13-09-2019
     * 
     * @return array  $objResponse
     */
    public function createPromocion($arrayData)
    {
        $intIdSucursal          = $arrayData['idSucursal'] ? $arrayData['idSucursal']:'';
        $strDescrPromocion      = $arrayData['descrPromocion'] ? $arrayData['descrPromocion']:'';
        $imgBase64              = $arrayData['rutaImagen'] ? $arrayData['rutaImagen']:'';
        $intCantPuntos          = $arrayData['cantPuntos'] ? $arrayData['cantPuntos']:'';
        $strAceptaGlobal        = $arrayData['aceptaGlobal'] ? $arrayData['aceptaGlobal']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        $objController          = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            $em->getConnection()->beginTransaction();
            if(!empty($imgBase64))
            {
                $strRutaImagen = $objController->subirfichero($imgBase64);
            }
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
            $entityPromocion->setIMAGEN($strRutaImagen);
            $entityPromocion->setCANTIDADPUNTOS($intCantPuntos);
            $entityPromocion->setACEPTAGLOBAL($strAceptaGlobal);
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
     * Documentación para la función 'editPromocion'
     * Método encargado de editar las promociones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 13-09-2019
     * 
     * @return array  $objResponse
     */
    public function editPromocion($arrayData)
    {
        $intIdPromocion         = $arrayData['idPromocion'] ? $arrayData['idPromocion']:'';
        $intIdSucursal          = $arrayData['idSucursal'] ? $arrayData['idSucursal']:'';
        $strDescrPromocion      = $arrayData['descrPromocion'] ? $arrayData['descrPromocion']:'';
        $imgBase64              = $arrayData['rutaImagen'] ? $arrayData['rutaImagen']:'';
        $intCantPuntos          = $arrayData['cantPuntos'] ? $arrayData['cantPuntos']:'';
        $strAceptaGlobal        = $arrayData['aceptaGlobal'] ? $arrayData['aceptaGlobal']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        $objController          = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            $em->getConnection()->beginTransaction();
            if(!empty($imgBase64))
            {
                $strRutaImagen = $objController->subirfichero($imgBase64);
            }
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
            if(!empty($strRutaImagen))
            {
                $objPromocion->setIMAGEN($strRutaImagen);
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
}
