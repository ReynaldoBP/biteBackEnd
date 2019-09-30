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
class InfoRestauranteController extends Controller
{
    /**
     * @Route("/createRestaurante")
     *
     * Documentación para la función 'createRestaurante'
     * Método encargado de crear los restaurantes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function createRestauranteAction(Request $request)
    {
        $strTipoComida          = $request->query->get("tipoComida") ? $request->query->get("tipoComida"):'';
        $strIdTipoComida        = $request->query->get("idTipoComida") ? $request->query->get("idTipoComida"):'';
        $strTipoIdentificacion  = $request->query->get("tipoIdentificacion") ? $request->query->get("tipoIdentificacion"):'';
        $strIdentificacion      = $request->query->get("identificacion") ? $request->query->get("identificacion"):'';
        $strRazonSocial         = $request->query->get("razonSocial") ? $request->query->get("razonSocial"):'';
        $strNombreComercial     = $request->query->get("nombreComercial") ? $request->query->get("nombreComercial"):'';
        $strRepresentanteLegal  = $request->query->get("representanteLegal") ? $request->query->get("representanteLegal"):'';
        $strDireccionTributario = $request->query->get("direcion") ? $request->query->get("direcion"):'';
        $strUrlCatalogo         = $request->query->get("urlCatalogo") ? $request->query->get("urlCatalogo"):'';
        $strNumeroContacto      = $request->query->get("numeroContacto") ? $request->query->get("numeroContacto"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
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
     * @Route("/editRestaurante")
     *
     * Documentación para la función 'editRestaurante'
     * Método encargado de editar los restaurantes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function editRestauranteAction(Request $request)
    {
        $strIdTipoComida        = $request->query->get("idTipoComida") ? $request->query->get("idTipoComida"):'';
        $strTipoIdentificacion  = $request->query->get("tipoIdentificacion") ? $request->query->get("tipoIdentificacion"):'';
        $strIdentificacion      = $request->query->get("identificacion") ? $request->query->get("identificacion"):'';
        $strIdRestaurante       = $request->query->get("idRestaurante") ? $request->query->get("idRestaurante"):'';
        $strRazonSocial         = $request->query->get("razonSocial") ? $request->query->get("razonSocial"):'';
        $strNombreComercial     = $request->query->get("nombreComercial") ? $request->query->get("nombreComercial"):'';
        $strRepresentanteLegal  = $request->query->get("representanteLegal") ? $request->query->get("representanteLegal"):'';
        $strDireccionTributario = $request->query->get("direcion") ? $request->query->get("direcion"):'';
        $strUrlCatalogo         = $request->query->get("urlCatalogo") ? $request->query->get("urlCatalogo"):'';
        $strNumeroContacto      = $request->query->get("numeroContacto") ? $request->query->get("numeroContacto"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
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
     * @Route("/getRestaurante")
     *
     * Documentación para la función 'getRestaurante'
     * Método encargado de retornar todos los restaurantes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function getRestauranteAction(Request $request)
    {
        $intIdRestaurante       = $request->query->get("idRestaurante") ? $request->query->get("idRestaurante"):'';
        $intIdUsuario           = $request->query->get("idUsuario") ? $request->query->get("idUsuario"):'';
        $strTipoComida          = $request->query->get("tipoComida") ? $request->query->get("tipoComida"):'';
        $strTipoIdentificacion  = $request->query->get("tipoIdentificacion") ? $request->query->get("tipoIdentificacion"):'';
        $strIdentificacion      = $request->query->get("identificacion") ? $request->query->get("identificacion"):'';
        $strRazonSocial         = $request->query->get("razonSocial") ? $request->query->get("razonSocial"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $strContador            = $request->query->get("strContador") ? $request->query->get("strContador"):'NO';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $conImagen              = $request->query->get("imagen") ? $request->query->get("imagen"):'NO';
        $conIcono               = $request->query->get("icono") ? $request->query->get("icono"):'NO';
        $arrayRestaurantes      = array();
        $strMensaje             = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        try
        {
            $objController    = new DefaultController();
            $objController->setContainer($this->container);
            $arrayParametros = array('strTipoComida'        => $strTipoComida,
                                    'intIdRestaurante'      => $intIdRestaurante,
                                    'intIdUsuario'          => $intIdUsuario,
                                    'strTipoIdentificacion' => $strTipoIdentificacion,
                                    'strIdentificacion'     => $strIdentificacion,
                                    'strRazonSocial'        => $strRazonSocial,
                                    'strContador'           => $strContador,
                                    'strEstado'             => $strEstado
                                    );
            $arrayRestaurantes   = (array) $this->getDoctrine()->getRepository('AppBundle:InfoRestaurante')->getRestauranteCriterio($arrayParametros);
            if(isset($arrayRestaurantes['error']) && !empty($arrayRestaurantes['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayRestaurantes['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensaje ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayRestaurantes['error'] = $strMensaje;
        if($conImagen == 'SI')
        {
            foreach ($arrayRestaurantes['resultados'] as &$item)
            {
                if($item['IMAGEN'])
                {
                    $item['IMAGEN'] = $objController->getImgBase64($item['IMAGEN']);
                }
            }
        }

        if($conIcono == 'SI')
        {
            foreach ($arrayRestaurantes['resultados'] as &$item)
            {
                if($item['ICONO'])
                {
                    $item['ICONO'] = $objController->getImgBase64($item['ICONO']);
                }
            }
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayRestaurantes,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
}
