<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoCliente;
use AppBundle\Entity\AdmiTipoRol;
use AppBundle\Controller\DefaultController;
use AppBundle\Entity\AdmiTipoClientePuntaje;
use AppBundle\Entity\InfoUsuario;
use AppBundle\Entity\AdmiParametro;
use AppBundle\Entity\InfoRestaurante;
use AppBundle\Entity\InfoEncuesta;
use AppBundle\Entity\InfoPregunta;
use AppBundle\Entity\InfoRespuesta;
use AppBundle\Entity\InfoPublicidad;
use AppBundle\Entity\InfoPromocion;
use AppBundle\Entity\InfoSucursal;
use AppBundle\Entity\InfoLikeRes;
use AppBundle\Entity\InfoClientePunto;
use AppBundle\Entity\InfoContenidoSubido;
use AppBundle\Entity\InfoRedesSociales;
use AppBundle\Entity\InfoClientePuntoGlobal;
use AppBundle\Entity\InfoOpcionRespuesta;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class ApiMovilController extends FOSRestController
{
   /**
   * @Rest\Post("/movilBitte/procesar")
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
               case 'createCliente':$arrayRespuesta = $this->createCliente($arrayData);
               break;
               case 'editCliente':$arrayRespuesta = $this->editCliente($arrayData);
               break;
               case 'getCliente':$arrayRespuesta = $this->getCliente($arrayData);
               break;
               case 'getSucursalPorUbicacion':$arrayRespuesta = $this->getSucursalPorUbicacion($arrayData);
               break;
               case 'getRestaurante':$arrayRespuesta = $this->getRestaurante($arrayData);
               break;
               case 'getEncuesta':$arrayRespuesta = $this->getEncuesta($arrayData);
               break;
               case 'getPregunta':$arrayRespuesta = $this->getPregunta($arrayData);
               break;
               case 'createRespuesta':$arrayRespuesta = $this->createRespuesta($arrayData);
               break;
               case 'getLoginMovil':$arrayRespuesta = $this->getLoginMovil($arrayData);
               break;
               case 'getPublicidad':$arrayRespuesta = $this->getPublicidad($arrayData);
               break;
               case 'createLike':$arrayRespuesta = $this->createLike($arrayData);
               break;
               case 'deleteLike':$arrayRespuesta = $this->deleteLike($arrayData);
               break;
               case 'createPunto':$arrayRespuesta = $this->createPunto($arrayData);
               break;
               case 'createContenido':$arrayRespuesta = $this->createContenido($arrayData);
               break;
               case 'createRedesSociales':$arrayRespuesta = $this->createRedesSociales($arrayData);
               break;
               case 'getPromocion':$arrayRespuesta = $this->getPromocion($arrayData);
               break;
               case 'createPuntoGlobal':$arrayRespuesta = $this->createPuntoGlobal($arrayData);
               break;
               default:
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
     * Documentación para la función 'createCliente'
     * Método encargado de crear todos los clientes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 26-08-2019
     * 
     * @return array  $objResponse
     */
    public function createCliente($arrayData)
    {
        $strIdentificacion  = $arrayData['identificacion'] ? $arrayData['identificacion']:'';
        $strDireccion       = $arrayData['direccion'] ? $arrayData['direccion']:'';
        $strEdad            = $arrayData['edad'] ? $arrayData['edad']:'';
        $strTipoComida      = $arrayData['tipoComida'] ? $arrayData['tipoComida']:'';
        $strEstado          = $arrayData['estado'] ? $arrayData['estado']:'';
        $strSector          = $arrayData['sector'] ? $arrayData['sector']:'';
        $strNombre          = $arrayData['nombre'] ? $arrayData['nombre']:'';
        $strApellido        = $arrayData['apellido'] ? $arrayData['apellido']:'';
        $strCorreo          = $arrayData['correo'] ? $arrayData['correo']:'';
        $strGenero          = $arrayData['genero'] ? $arrayData['genero']:'';
        $intIdTipoCLiente   = $arrayData['idTipoCLiente'] ? $arrayData['idTipoCLiente']:'';
        $intIdUsuario       = $arrayData['idUsuario'] ? $arrayData['idUsuario']:'';
        $strContrasenia     = $arrayData['contrasenia'] ? $arrayData['contrasenia']:'';
        $strAutenticacionRS = $arrayData['autenticacionRS'] ? $arrayData['autenticacionRS']:'';
        $strUsuarioCreacion = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual  = new \DateTime('now');
        $arrayCliente       = array();
        $strMensajeError    = '';
        $strStatus          = 400;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $objClt         = $em->getRepository('AppBundle:InfoCliente')->findOneBy(array('CORREO'=>$strCorreo));
            if(is_object($objClt) || !empty($objClt))
            {
                throw new \Exception('Cliente ya existente.');
            }
            $arrayParametrosTipoCliente = array('ESTADO' => 'ACTIVO',
                                                'id'     => $intIdTipoCLiente);
            $objTipoCliente             = $em->getRepository('AppBundle:AdmiTipoClientePuntaje')->findOneBy($arrayParametrosTipoCliente);
            if(!is_object($objTipoCliente) || empty($objTipoCliente))
            {
                throw new \Exception('No existe tipo cliente con la descripción enviada por parámetro.');
            }
            $arrayParametrosUsuario = array('ESTADO' => 'ACTIVO',
                                                'id'     => $intIdUsuario);
            $objUsuario             = $em->getRepository('AppBundle:InfoUsuario')->findOneBy($arrayParametrosUsuario);
            if(!is_object($objUsuario) || empty($objUsuario))
            {
                throw new \Exception('No existe usuario con identificador enviado por parámetro.');
            }

            $entityCliente = new InfoCliente();
            $entityCliente->setAUTENTICACIONRS($strAutenticacionRS);
            $entityCliente->setCONTRASENIA(md5($strContrasenia));
            $entityCliente->setIDENTIFICACION($strIdentificacion);
            $entityCliente->setDIRECCION($strDireccion);
            $entityCliente->setEDAD($strEdad);
            $entityCliente->setTIPOCOMIDA($strTipoComida);
            $entityCliente->setGENERO($strGenero);
            $entityCliente->setESTADO(strtoupper($strEstado));
            $entityCliente->setSECTOR($strSector);
            $entityCliente->setTIPOCLIENTEPUNTAJEID($objTipoCliente);
            $entityCliente->setUSUARIOID($objUsuario);
            $entityCliente->setNOMBRE($strNombre);
            $entityCliente->setAPELLIDO($strApellido);
            $entityCliente->setCORREO($strCorreo);
            $entityCliente->setUSRCREACION($strUsuarioCreacion);
            $entityCliente->setFECREACION($strDatetimeActual);
            $em->persist($entityCliente);
            $em->flush();
            $strMensajeError = 'Usuario creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError ="Fallo al crear el cliente, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
            $arrayCliente = array('id'             => $entityCliente->getId(),
                                    'identificacion' => $entityCliente->getIDENTIFICACION(),
                                    'nombre'         => $entityCliente->getNOMBRE(),
                                    'apellido'       => $entityCliente->getAPELLIDO(),
                                    'correo'         => $entityCliente->getCORREO(),
                                    'direccion'      => $entityCliente->getDIRECCION(),
                                    'edad'           => $entityCliente->getEDAD(),
                                    'tipoComida'     => $entityCliente->getTIPOCOMIDA(),
                                    'genero'         => $entityCliente->getGENERO(),
                                    'estado'         => $entityCliente->getESTADO(),
                                    'sector'         => $entityCliente->getSECTOR(),
                                    'usrCreacion'    => $entityCliente->getUSRCREACION(),
                                    'feCreacion'     => $entityCliente->getFECREACION());
        }
        $arrayCliente['mensaje'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayCliente,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'editCliente'
     * Método encargado de editar todos los clientes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 26-08-2019
     * 
     * @return array  $objResponse
     */
    public function editCliente($arrayData)
    {
        $intIdCliente       = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $strIdentificacion  = $arrayData['identificacion'] ? $arrayData['identificacion']:'';
        $strDireccion       = $arrayData['direccion'] ? $arrayData['direccion']:'';
        $strEdad            = $arrayData['edad'] ? $arrayData['edad']:'';
        $strTipoComida      = $arrayData['tipoComida'] ? $arrayData['tipoComida']:'';
        $strEstado          = $arrayData['estado'] ? $arrayData['estado']:'';
        $strSector          = $arrayData['sector'] ? $arrayData['sector']:'';
        $strNombre          = $arrayData['nombre'] ? $arrayData['nombre']:'';
        $strApellido        = $arrayData['apellido'] ? $arrayData['apellido']:'';
        $strCorreo          = $arrayData['correo'] ? $arrayData['correo']:'';
        $strGenero          = $arrayData['genero'] ? $arrayData['genero']:'';
        $intIdTipoCLiente   = $arrayData['idTipoCLiente'] ? $arrayData['idTipoCLiente']:'';
        $intIdUsuario       = $arrayData['idUsuario'] ? $arrayData['idUsuario']:'';
        $strContrasenia     = $arrayData['contrasenia'] ? $arrayData['contrasenia']:'';
        $strAutenticacionRS = $arrayData['autenticacionRS'] ? $arrayData['autenticacionRS']:'';
        $strUsuarioModif    = $arrayData['usuarioModificacion'] ? $arrayData['usuarioModificacion']:'';
        $strDatetimeActual  = new \DateTime('now');
        $strMensajeError    = '';
        $strStatus          = 400;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $objCliente = $em->getRepository('AppBundle:InfoCliente')->findOneBy(array('id'=>$intIdCliente));
            if(!is_object($objCliente) || empty($objCliente))
            {
                throw new \Exception('No existe cliente con el identificador enviado por parámetro.');
            }
            if(!empty($intIdTipoCLiente))
            {
                $arrayParametrosTipoCliente = array('ESTADO' => 'ACTIVO',
                                                    'id'     => $intIdTipoCLiente);
                $objTipoCliente             = $em->getRepository('AppBundle:AdmiTipoClientePuntaje')->findOneBy($arrayParametrosTipoCliente);
                if(!is_object($objTipoCliente) || empty($objTipoCliente))
                {
                    throw new \Exception('No existe tipo cliente con la descripción enviada por parámetro.');
                }
                $objCliente->setTIPOCLIENTEPUNTAJEID($objTipoCliente);
            }
            if(!empty($intIdUsuario))
            {
                $arrayParametrosUsuario = array('ESTADO' => 'ACTIVO',
                                                'id'     => $intIdUsuario);
                $objUsuario             = $em->getRepository('AppBundle:InfoUsuario')->findOneBy($arrayParametrosUsuario);
                if(!is_object($objUsuario) || empty($objUsuario))
                {
                    throw new \Exception('No existe usuario con identificador enviado por parámetro.');
                }
                $objCliente->setUSUARIOID($objUsuario);
            }
            if(!empty($strContrasenia))
            {
                $objCliente->setCONTRASENIA(md5($strContrasenia));
            }
            if(!empty($strAutenticacionRS))
            {
                $objCliente->setAUTENTICACIONRS($strAutenticacionRS);
            }
            if(!empty($strIdentificacion))
            {
                $objCliente->setIDENTIFICACION($strIdentificacion);
            }
            if(!empty($strDireccion))
            {
                $objCliente->setDIRECCION($strDireccion);
            }
            if(!empty($strEdad))
            {
                $objCliente->setEDAD($strEdad);
            }
            if(!empty($strTipoComida))
            {
                $objCliente->setTIPOCOMIDA($strTipoComida);
            }
            if(!empty($strGenero))
            {
                $objCliente->setGENERO($strGenero);
            }
            if(!empty($strEstado))
            {
                $objCliente->setESTADO(strtoupper($strEstado));
            }
            if(!empty($strSector))
            {
                $objCliente->setSECTOR($strSector);
            }
            if(!empty($strNombre))
            {
                $objCliente->setNOMBRE($strNombre);
            }
            if(!empty($strApellido))
            {
                $objCliente->setAPELLIDO($strApellido);
            }
            if(!empty($strCorreo))
            {
                $objCliente->setCORREO($strCorreo);
            }
            $objCliente->setUSRMODIFICACION($strUsuarioModif);
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
            $strMensajeError ="Fallo al editar el cliente, intente nuevamente.\n ". $ex->getMessage();
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
     * Documentación para la función 'getCliente'
     * Método encargado de retornar todos los clientes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function getCliente($arrayData)
    {
        $intIdCliente      = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $strIdentificacion = $arrayData['identificacion'] ? $arrayData['identificacion']:'';
        $strNombres        = $arrayData['nombres'] ? $arrayData['nombres']:'';
        $strApellidos      = $arrayData['apellidos'] ? $arrayData['apellidos']:'';
        $strEstado         = $arrayData['estado'] ? $arrayData['estado']:'';
        $arrayCliente      = array();
        $strMensajeError   = '';
        $strStatus         = 400;
        $objResponse       = new Response;
        try
        {
            $arrayParametros = array('intIdCliente'     => $intIdCliente,
                                    'strIdentificacion' => $strIdentificacion,
                                    'strNombres'        => $strNombres,
                                    'strApellidos'      => $strApellidos,
                                    'strEstado'         => $strEstado
                                    );
            $arrayCliente   = $this->getDoctrine()->getRepository('AppBundle:InfoCliente')->getClienteCriterioMovil($arrayParametros);
            if(isset($arrayCliente['error']) && !empty($arrayCliente['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayCliente['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayCliente['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayCliente,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * Documentación para la función 'getSucursalPorUbicacion'
     * Método encargado de retornar todos las sucursales según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 28-08-2019
     * 
     * @return array  $objResponse
     */
    public function getSucursalPorUbicacion($arrayData)
    {
        $strLatitud        = $arrayData['latitud'] ? $arrayData['latitud']:'';
        $strLongitud       = $arrayData['longitud'] ? $arrayData['longitud']:'';
        $strEstado         = $arrayData['estado'] ? $arrayData['estado']:'';
        $arraySucursal     = array();
        $strMensajeError   = '';
        $strStatus         = 400;
        $strMetros         = 0;
        $objResponse       = new Response;
        $strDescripcion    = 'CANTIDAD_DISTANCIA';
        try
        {
            $objParametro    = $this->getDoctrine()->getRepository('AppBundle:AdmiParametro')->findOneBy(array('ESTADO'      => 'ACTIVO',
                                                                                                               'DESCRIPCION'  => $strDescripcion));
            $arrayParametros = array('latitud' => $strLatitud,
                                    'longitud' => $strLongitud,
                                    'estado'   => $strEstado,
                                    'metros'   => $objParametro->getVALOR2()
                                    );
            $arraySucursal   = $this->getDoctrine()->getRepository('AppBundle:InfoSucursal')->getSucursalPorUbicacion($arrayParametros);
            if(isset($arraySucursal['error']) && !empty($arraySucursal['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arraySucursal['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arraySucursal['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arraySucursal,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * Documentación para la función 'getRestaurante'
     * Método encargado de retornar todos los restaurantes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 28-08-2019
     * 
     * @return array  $objResponse
     */
    public function getRestaurante($arrayData)
    {
        $intIdRestaurante       = $arrayData['idRestaurante'] ? $arrayData['idRestaurante']:'';
        $intIdCliente           = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $strTipoComida          = $arrayData['tipoComida'] ? $arrayData['tipoComida']:'';
        $strTipoIdentificacion  = $arrayData['tipoIdentificacion'] ? $arrayData['tipoIdentificacion']:'';
        $strIdentificacion      = $arrayData['identificacion'] ? $arrayData['identificacion']:'';
        $strRazonSocial         = $arrayData['razonSocial'] ? $arrayData['razonSocial']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $conImagen              = $arrayData['imagen'] ? $arrayData['imagen']:'NO';
        $conIcono               = $arrayData['icono']  ? $arrayData['icono']:'NO';
        $arrayRestaurante       = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $strMetros              = 0;
        $objResponse            = new Response;
        try
        {
            $objController    = new DefaultController();
            $objController->setContainer($this->container);
            $arrayParametros = array('strTipoComida'        => $strTipoComida,
                                    'intIdRestaurante'      => $intIdRestaurante,
                                    'intIdCliente'          => $intIdCliente,
                                    'strTipoIdentificacion' => $strTipoIdentificacion,
                                    'strIdentificacion'     => $strIdentificacion,
                                    'strRazonSocial'        => $strRazonSocial,
                                    'strEstado'             => $strEstado
                                    );
            $arrayRestaurante   = (array) $this->getDoctrine()->getRepository('AppBundle:InfoRestaurante')->getRestauranteCriterioMovil($arrayParametros);
            if(isset($arrayRestaurante['error']) && !empty($arrayRestaurante['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayRestaurante['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        if($conImagen == 'SI')
        {
            foreach ($arrayRestaurante['resultados'] as &$item)
            {
                if($item['IMAGEN'])
                {
                    $item['IMAGEN'] = $objController->getImgBase64($item['IMAGEN']);
                }
            }
        }

        if($conIcono == 'SI')
        {
            foreach ($arrayRestaurante['resultados'] as &$item)
            {
                if($item['ICONO'])
                {
                    $item['ICONO'] = $objController->getImgBase64($item['ICONO']);
                }
            }
        }
        $arrayRestaurante['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayRestaurante,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'getEncuesta'
     * Método encargado de listar las encuestas según los parámetros recibidos.
     *
     * @author Kevin Baque
     * @version 1.0 02-09-2019
     *
     * @return array  $objResponse
     */
    public function getEncuesta($arrayData)
    {
        $strIdRestaurante       = $arrayData['idRestaurante'] ? $arrayData['idRestaurante']:'';
        $strIdEncuesta          = $arrayData['idEncuesta'] ? $arrayData['idEncuesta']:'';
        $strDescripcion         = $arrayData['descripcion'] ? $arrayData['descripcion']:'';
        $strTitulo              = $arrayData['titulo'] ? $arrayData['titulo']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $boolSucces             = true;
        $arrayPregunta          = array();
        $arrayEncuesta          = array();
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $arrayParametros = array(
                                     'ESTADO'         => $strEstado);
            $objEncuesta     = $em->getRepository('AppBundle:InfoEncuesta')->findBy($arrayParametros);            
            if(empty($objEncuesta) && !is_array($objEncuesta))
            {
                throw new \Exception('La encuesta a buscar no existe.');
            }
            foreach($objEncuesta as $arrayItem)
            {
                $arrayParametrosPreg = array('ESTADO'     => 'ACTIVO',
                                             'ENCUESTA_ID' => $arrayItem->getId());                
                $objPregunta         = 
$em->getRepository('AppBundle:InfoPregunta')->findBy($arrayParametrosPreg);
                if(!empty($objPregunta) && is_array($objPregunta))
                {
                    foreach($objPregunta as $arrayItemPregunta)
                    {
                        $arrayPregunta[] = array('idPregunta'      => $arrayItemPregunta->getId(),
                                                 'descripcion'     => $arrayItemPregunta->getDESCRIPCION(),
                                                 'obligatoria'     => $arrayItemPregunta->getOBLIGATORIA(),
                                                 'idTipoRespuesta' => $arrayItemPregunta->getOPCIONRESPUESTAID()->getId(),
                                                 'tipoRespuesta'   => $arrayItemPregunta->getOPCIONRESPUESTAID()->getTIPORESPUESTA(),
                                                 'cantOpcion'      => $arrayItemPregunta->getOPCIONRESPUESTAID()->getValor(),
                                                 'estado'          => $arrayItemPregunta->getESTADO());
                    }
                }
                $arrayEncuesta = array( 'descripcionEncuesta' => $arrayItem->getDESCRIPCION(),
                                        'tituloEncuesta'      => $arrayItem->getTITULO(),
                                        'preguntas'           => $arrayPregunta);
            }
        }
        catch(\Exception $ex)
        {
            $boolSucces             = false;
            $strStatus              = 404;
            $strMensaje             ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
            $arrayEncuesta['error'] = $strMensaje;
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayEncuesta,
                                            'succes'    => $boolSucces
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'getPregunta'
     * Método encargado de listar las preguntas según los parámetros recibidos.
     *
     * @author Kevin Baque
     * @version 1.0 29-08-2019
     * 
     * @return array  $objResponse
     */
    public function getPregunta($arrayData)
    {
        $strIdEncuesta          = $arrayData['idEncuesta'] ? $arrayData['idEncuesta']:'';
        $strIdPregunta          = $arrayData['idPregunta'] ? $arrayData['idPregunta']:'';
        $strDescripcion         = $arrayData['descripcion'] ? $arrayData['descripcion']:'';
        $strObligatoria         = $arrayData['obligatoria'] ? $arrayData['obligatoria']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
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
            $arrayEncuesta = $this->getDoctrine()->getRepository('AppBundle:InfoPregunta')->getPreguntaCriterioMovil($arrayParametros);
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
    /**
     * Documentación para la función 'createRespuesta'
     * Método encargado de crear todas las respuesta según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 04-09-2019
     * 
     * @return array  $objResponse
     */
    public function createRespuesta($arrayData)
    {
        $intIdPregunta      = $arrayData['idPregunta'] ? $arrayData['idPregunta']:'';
        $intIdCliente       = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $intIdContenido     = $arrayData['idContenido'] ? $arrayData['idContenido']:'';
        $strRespuesta       = $arrayData['respuesta'] ? $arrayData['respuesta']:'';
        $strEstado          = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $strUsuarioCreacion = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual  = new \DateTime('now');
        $arrayRespuesta     = array();
        $strMensajeError    = '';
        $strStatus          = 400;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $arrayParametrosClt = array('ESTADO' => 'ACTIVO',
                                        'id'     => $intIdCliente);
            $objCliente         = $em->getRepository('AppBundle:InfoCliente')->findOneBy($arrayParametrosClt);
            if(!is_object($objCliente) || empty($objCliente))
            {
                throw new \Exception('No existe cliente con la descripción enviada por parámetro.');
            }
            $arrayParametrosPreg = array('ESTADO' => 'ACTIVO',
                                         'id'     => $intIdPregunta);
            $objPregunta    = $em->getRepository('AppBundle:InfoPregunta')->findOneBy($arrayParametrosPreg);
            if(!is_object($objPregunta) || empty($objPregunta))
            {
                throw new \Exception('No existe la pregunta con la descripción enviada por parámetro.');
            }
            $objContenido    = $em->getRepository('AppBundle:InfoContenidoSubido')->find($intIdContenido);
            if(!is_object($objContenido) || empty($objContenido))
            {
                throw new \Exception('No existe el contenido con la descripción enviada por parámetro.');
            }
            $entityRespuesta = new InfoRespuesta();
            $entityRespuesta->setRESPUESTA($strRespuesta);
            $entityRespuesta->setPREGUNTAID($objPregunta);
            $entityRespuesta->setCLIENTEID($objCliente);
            $entityRespuesta->setCONTENIDOID($objContenido);
            $entityRespuesta->setESTADO(strtoupper($strEstado));
            $entityRespuesta->setUSRCREACION($strUsuarioCreacion);
            $entityRespuesta->setFECREACION($strDatetimeActual);
            $em->persist($entityRespuesta);
            $em->flush();
            $strMensajeError = 'Respuesta creada con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError ="Fallo al crear la respuesta, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
            $arrayRespuesta = array('idRespuesta'   => $entityRespuesta->getId(),
                                  'respuesta'       => $entityRespuesta->getRESPUESTA(),
                                  'estadoRespuesta' => $entityRespuesta->getESTADO(),
                                  'nombreClt'       => $entityRespuesta->getCLIENTEID()->getNOMBRE(),
                                  'apellidoClt'     => $entityRespuesta->getCLIENTEID()->getAPELLIDO(),
                                  'correoClt'       => $entityRespuesta->getCLIENTEID()->getCORREO(),
                                  'direccionClt'    => $entityRespuesta->getCLIENTEID()->getDIRECCION(),
                                  'idPregunta'      => $entityRespuesta->getPREGUNTAID()->getId(),
                                  'preguntaDescrip' => $entityRespuesta->getPREGUNTAID()->getDESCRIPCION(),
                                  'preguntaObl'     => $entityRespuesta->getPREGUNTAID()->getOBLIGATORIA(),
                                  'preguntaDesc'    => $entityRespuesta->getPREGUNTAID()->getDESCRIPCION(),
                                  'usrCreacion'     => $entityRespuesta->getUSRCREACION(),
                                  'feModificacion'  => $entityRespuesta->getFECREACION());
        }
        $arrayRespuesta['mensaje'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayRespuesta,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'getLoginMovil'
     * Método encargado de verificar si ingresa a la plataforma movil según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 06-09-2019
     * 
     * @return array  $objResponse
     */
    public function getLoginMovil($arrayData)
    {
        $strCorreo          = $arrayData['correo'] ? $arrayData['correo']:'';
        $strPass            = $arrayData['contrasenia'] ? $arrayData['contrasenia']:'';
        $strAutenticacionRS = $arrayData['autenticacionRS'] ? $arrayData['autenticacionRS']:'';
        $arrayCliente       = array();
        $strMensaje         = '';
        $strStatus          = 400;
        $strSucces          = true;
        $objResponse        = new Response;
        try
        {
            $arrayParametros = array('CORREO' => $strCorreo);
            if($strAutenticacionRS == 'N')
            {
                $arrayParametros['CONTRASENIA'] = md5($strPass);
            }
            $objCliente   = $this->getDoctrine()->getRepository('AppBundle:InfoCliente')->findBy($arrayParametros);
            if(empty($objCliente))
            {
                $strStatus  = 404;
                $strSucces  = false;
                throw new \Exception('Cliente no existe.');
            }
            foreach($objCliente as $objItemCliente)
            {
                $arrayCliente   = array('idCliente'       => $objItemCliente->getId(),
                                        'autenticacionRS' => $objItemCliente->getAUTENTICACIONRS(),
                                        'identificacion'  => $objItemCliente->getIDENTIFICACION(),
                                        'nombre'          => $objItemCliente->getNOMBRE(),
                                        'apellido'        => $objItemCliente->getAPELLIDO(),
                                        'correo'          => $objItemCliente->getCORREO(),
                                        'edad'            => $objItemCliente->getEDAD(),
                                        'genero'          => $objItemCliente->getGENERO(),
                                        'strEstado'       => $objItemCliente->getESTADO()
                                        );
            }
        }
        catch(\Exception $ex)
        {
            $strStatus = 404;
            $arrayCliente['error'] = $strMensaje;
            $strMensaje = $ex->getMessage();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayCliente,
                                            'succes'    => $strSucces
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'getPublicidad'
     * Método encargado de retornar las publicidades según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 06-09-2019
     * 
     * @return array  $objResponse
     */
    public function getPublicidad($arrayData)
    {
        $intIdPublicidad        = $arrayData['idPublicidad'] ? $arrayData['idPublicidad']:'';
        $intIdCliente           = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $intIdSucursal          = $arrayData['idSucursal'] ? $arrayData['idSucursal']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $conImagen              = $arrayData['imagen'] ? $arrayData['imagen']:'NO';
        $arrayPublicidad        = array();
        $arrayCliente           = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        $objController    = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            $objCliente = $em->getRepository('AppBundle:InfoCliente')->find($intIdCliente);
            if(!empty($objCliente))
            {
                $arrayCliente   = array('idCliente'      => $objCliente->getId(),
                                        'identificacion' => $objCliente->getIDENTIFICACION(),
                                        'nombre'         => $objCliente->getNOMBRE(),
                                        'apellido'       => $objCliente->getAPELLIDO(),
                                        'correo'         => $objCliente->getCORREO(),
                                        'direccion'      => $objCliente->getDIRECCION(),
                                        'genero'         => $objCliente->getGENERO(),
                                        'edad'           => $objCliente->getEDAD(),
                                        'idComida'       => $objCliente->getTIPOCLIENTEPUNTAJEID()->getId());
            }
            if(!empty($intIdSucursal))
            {
                $objSucursal = $em->getRepository('AppBundle:InfoSucursal')->find($intIdSucursal);
                if(!empty($objSucursal))
                {
                    $arraySucursal = array('idSucursal'  => $objSucursal->getId(),
                                           'descripcion' => $objSucursal->getDESCRIPCION(),
                                           'pais'        => $objSucursal->getPAIS(),
                                           'ciudad'      => $objSucursal->getCIUDAD(),
                                           'provincia'   => $objSucursal->getPROVINCIA(),
                                           'parroquia'   => $objSucursal->getPARROQUIA());
                }
            }
            $arrayParametros = array('PAIS'      => $arraySucursal['pais'],
                                     'CIUDAD'    => $arraySucursal['ciudad'],
                                     'PROVINCIA' => $arraySucursal['provincia'],
                                     'PARROQUIA' => $arraySucursal['parroquia'],
                                     'EDAD'      => $arrayCliente['edad'],
                                     'GENERO'    => $arrayCliente['genero']);
            $arrayPublicidad = (array) $this->getDoctrine()->getRepository('AppBundle:InfoPublicidad')->getPublicidadCriterioMovil($arrayParametros);
            if(empty($arrayPublicidad) || $arrayPublicidad['cantidad']==0)
            {
                $arrayPublicidad = (array) $this->getDoctrine()->getRepository('AppBundle:InfoPublicidad')->getPublicidadCriterioMovil(array('GENERO' => 'TODOS'));
                if(empty($arrayPublicidad))
                {
                    $strStatus  = 404;
                    throw new \Exception('No existen publicidades con la descripción enviada por parametro222s');
                }
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError          ="Falló al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
            $arrayPublicidad['error'] = $strMensajeError;
        }
        foreach ($arrayPublicidad['resultados'] as $item)
        {
            $arrayPublicidadMovil = array('ID_PUBLICIDAD'    => $item['ID_PUBLICIDAD'],
                                          'IMAGEN'           => $item['IMAGEN'],
                                          'DESCRIPCION'      => $item['DESCRIPCION'],
                                          'EDAD_MAXIMA'      => $item['EDAD_MAXIMA'],
                                          'EDAD_MINIMA'      => $item['EDAD_MINIMA'],
                                          'GENERO'           => $item['GENERO'],
                                          'ESTADO'           => $item['ESTADO'],
                                          'USR_CREACION'     => $item['USR_CREACION'],
                                          'FE_CREACION'      => $item['FE_CREACION'],
                                          'USR_MODIFICACION' => $item['USR_MODIFICACION'],
                                          'FE_MODIFICACION'  => $item['FE_MODIFICACION'],
                                          'ERROR'            => $strMensajeError);
            if(!empty($item['IMAGEN']) && $conImagen == 'SI')
            {
                $arrayPublicidadMovil['IMAGEN'] = $objController->getImgBase64($item['IMAGEN']);
            }
        }
        $objResponse->setContent(json_encode(array(
                                                    'status'    => $strStatus,
                                                    'resultado' => $arrayPublicidadMovil,
                                                    'succes'    => true)
                                            ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'createLike'
     * Método encargado de crear todos los likes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 20-09-2019
     * 
     * @return array  $objResponse
     */
    public function createLike($arrayData)
    {
        $strEstado          = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $intIdCliente       = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $intIdRestaurante   = $arrayData['idRestaurante'] ? $arrayData['idRestaurante']:'';
        $strUsuarioCreacion = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual  = new \DateTime('now');
        $strMensajeError    = '';
        $strStatus          = 400;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $objCliente = $em->getRepository('AppBundle:InfoCliente')->find($intIdCliente);
            if(!is_object($objCliente) || empty($objCliente))
            {
                throw new \Exception('No existe el cliente con identificador enviada por parámetro.');
            }
            $objRestaurante = $em->getRepository('AppBundle:InfoRestaurante')->find($intIdRestaurante);
            if(!is_object($objRestaurante) || empty($objRestaurante))
            {
                throw new \Exception('No existe restaurante con identificador enviado por parámetro.');
            }

            $entityLike = new InfoLikeRes();
            $entityLike->setCLIENTEID($objCliente);
            $entityLike->setRESTAURANTEID($objRestaurante);
            $entityLike->setESTADO(strtoupper($strEstado));
            $entityLike->setUSRCREACION($strUsuarioCreacion);
            $entityLike->setFECREACION($strDatetimeActual);
            $em->persist($entityLike);
            $em->flush();
            $strMensajeError = 'Like creada con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError ="Fallo al crear el like, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
            $arrayLike = array('id' => $entityLike->getId());
        }
        $arrayLike['mensaje'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayLike,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'deleteLike'
     * Método encargado de deletiar todos los likes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 20-09-2019
     * 
     * @return array  $objResponse
     */
    public function deleteLike($arrayData)
    {
        $intIdLike          = $arrayData['idLike'] ? $arrayData['idLike']:'';
        $strMensajeError    = '';
        $strStatus          = 400;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $objLike = $em->getRepository('AppBundle:InfoLikeRes')->find($intIdLike);
            if(!is_object($objLike) || empty($objLike))
            {
                throw new \Exception('No existe el Like con identificador enviada por parámetro.');
            }
            $em->remove($objLike);
            $em->flush();
            $strMensajeError = 'Like eliminado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError ="Fallo al eliminar el like, intente nuevamente.\n ". $ex->getMessage();
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
     * Documentación para la función 'createPunto'
     * Método encargado de crear todos los puntos según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 20-09-2019
     * 
     * @return array  $objResponse
     */
    public function createPunto($arrayData)
    {
        $strEstado          = $arrayData['estado'] ? $arrayData['estado']:'PENDIENTE';
        $intCantPuntos      = $arrayData['cantPuntos'] ? $arrayData['cantPuntos']:'';
        $intIdCliente       = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $intIdSucursal      = $arrayData['idSucursal'] ? $arrayData['idSucursal']:'';
        $strUsuarioCreacion = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual  = new \DateTime('now');
        $strMensajeError    = '';
        $strStatus          = 400;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $objCliente = $em->getRepository('AppBundle:InfoCliente')->find($intIdCliente);
            if(!is_object($objCliente) || empty($objCliente))
            {
                throw new \Exception('No existe el cliente con identificador enviada por parámetro.');
            }
            $objSucursal = $em->getRepository('AppBundle:InfoSucursal')->find($intIdSucursal);
            if(!is_object($objSucursal) || empty($objSucursal))
            {
                throw new \Exception('No existe sucursal con identificador enviado por parámetro.');
            }

            $entityCltPunto = new InfoClientePunto();
            $entityCltPunto->setCLIENTEID($objCliente);
            $entityCltPunto->setSUCURSALID($objSucursal);
            $entityCltPunto->setCANTIDADPUNTOS($intCantPuntos);
            $entityCltPunto->setESTADO(strtoupper($strEstado));
            $entityCltPunto->setUSRCREACION($strUsuarioCreacion);
            $entityCltPunto->setFECREACION($strDatetimeActual);
            $em->persist($entityCltPunto);
            $em->flush();
            $strMensajeError = 'Punto creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError ="Fallo al crear el Punto, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
            $arrayCltPunto = array('id'             => $entityCltPunto->getId(),
                                  'cantPuntos'      => $entityCltPunto->getCANTIDADPUNTOS(),
                                  'estado'          => $entityCltPunto->getESTADO(),
                                  'usrCreacion'     => $entityCltPunto->getUSRCREACION(),
                                  'feCreacion'      => $entityCltPunto->getFECREACION());
        }
        $arrayCltPunto['strMensajeError'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayCltPunto,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * Documentación para la función 'createContenido'
     * Método encargado de crear todos los contenidos según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 20-09-2019
     * 
     * @return array  $objResponse
     */
    public function createContenido($arrayData)
    {
        $intIdCliente       = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $strDescripcion     = $arrayData['descripcion'] ? $arrayData['descripcion']:'';
        $strEstado          = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $strImagen          = $arrayData['rutaImagen'] ? $arrayData['rutaImagen']:'';
        $strUsuarioCreacion = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual  = new \DateTime('now');
        $strMensajeError    = '';
        $strStatus          = 400;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        $objController      = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            $em->getConnection()->beginTransaction();
            if(!empty($strImagen))
            {
                $strRutaImagen = $objController->subirfichero($strImagen);
            }
            $objCliente = $em->getRepository('AppBundle:InfoCliente')->find($intIdCliente);
            if(!is_object($objCliente) || empty($objCliente))
            {
                throw new \Exception('No existe el cliente con identificador enviada por parámetro.');
            }

            $entityContSub = new InfoContenidoSubido();
            $entityContSub->setCLIENTEID($objCliente);
            $entityContSub->setDESCRIPCION($strDescripcion);
            $entityContSub->setIMAGEN($strRutaImagen);
            $entityContSub->setESTADO(strtoupper($strEstado));
            $entityContSub->setUSRCREACION($strUsuarioCreacion);
            $entityContSub->setFECREACION($strDatetimeActual);
            $em->persist($entityContSub);
            $em->flush();
            $strMensajeError = 'Contenido creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError ="Fallo al crear el Contenido, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
            $arrayContenido = array('id'            => $entityContSub->getId(),
                                  'cantPuntos'      => $entityContSub->getDESCRIPCION(),
                                  'estado'          => $entityContSub->getESTADO(),
                                  'usrCreacion'     => $entityContSub->getUSRCREACION(),
                                  'feCreacion'      => $entityContSub->getFECREACION());
        }
        $arrayContenido['strMensajeError'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayContenido,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * Documentación para la función 'createRedesSociales'
     * Método encargado de crear todos las redes sociales según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 20-09-2019
     * 
     * @return array  $objResponse
     */
    public function createRedesSociales($arrayData)
    {
        $intIdContSubido    = $arrayData['idContSubido'] ? $arrayData['idContSubido']:'';
        $strDescripcion     = $arrayData['descripcion'] ? $arrayData['descripcion']:'';
        $strEstado          = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $strUsuarioCreacion = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual  = new \DateTime('now');
        $strMensajeError    = '';
        $strStatus          = 400;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $objContSubido = $em->getRepository('AppBundle:InfoContenidoSubido')->find($intIdContSubido);
            if(!is_object($objContSubido) || empty($objContSubido))
            {
                throw new \Exception('No existe el contenido con identificador enviada por parámetro.');
            }

            $entityRedesSociales = new InfoRedesSociales();
            $entityRedesSociales->setCONTENIDOSUBIDOID($objContSubido);
            $entityRedesSociales->setDESCRIPCION($strDescripcion);
            $entityRedesSociales->setESTADO(strtoupper($strEstado));
            $entityRedesSociales->setUSRCREACION($strUsuarioCreacion);
            $entityRedesSociales->setFECREACION($strDatetimeActual);
            $em->persist($entityRedesSociales);
            $em->flush();
            $strMensajeError = 'Redes Sociales creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError ="Fallo al crear las Redes Sociales, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
            $arrayRedesSoc = array('id'             => $entityRedesSociales->getId(),
                                  'descripcion'     => $entityRedesSociales->getDESCRIPCION(),
                                  'idContSubido'    => $entityRedesSociales->getCONTENIDOSUBIDOID()->getId(),
                                  'descContSubido'  => $entityRedesSociales->getCONTENIDOSUBIDOID()->getDESCRIPCION(),
                                  'estado'          => $entityRedesSociales->getESTADO(),
                                  'usrCreacion'     => $entityRedesSociales->getUSRCREACION(),
                                  'feCreacion'      => $entityRedesSociales->getFECREACION()
                                );
        }
        $arrayRedesSoc[strMensajeError] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayRedesSoc,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'getPromocion'
     * Método encargado de listar las promociones según los parámetros recibidos.
     *
     * @author Kevin Baque
     * @version 1.0 02-09-2019
     *
     * @return array  $objResponse
     */
    public function getPromocion($arrayData)
    {
        $intIdSucursal          = $arrayData['idSucursal'] ? $arrayData['idSucursal']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $boolSucces             = true;
        $arrayPromocion         = array();
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        $objController          = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            $objPromocion     = $em->getRepository('AppBundle:InfoPromocion')->findBy(array('ESTADO' => $strEstado));
            if(empty($objPromocion) && !is_array($objPromocion))
            {
                throw new \Exception('La promoción a buscar no existe.');
            }
            foreach($objPromocion as $arrayItem)
            {
                if(!empty($arrayItem->getIMAGEN()))
                {
                    $strRutaImagen = $objController->getImgBase64($arrayItem->getIMAGEN());
                }
                $arrayPromocion []= array( 'idPromocion'   => $arrayItem->getId(),
                                        'descripcion'      => $arrayItem->getDESCRIPCIONTIPOPROMOCION(),
                                        'imagen'           => $strRutaImagen ? $strRutaImagen:'',
                                        'imagen2'          => $arrayItem->getIMAGEN(),
                                        'cantPuntos'       => $arrayItem->getCANTIDADPUNTOS(),
                                        'aceptaGlobal'     => $arrayItem->getACEPTAGLOBAL(),
                                        'estado'           => $arrayItem->getESTADO());
            }
        }
        catch(\Exception $ex)
        {
            $boolSucces              = false;
            $strStatus               = 404;
            $strMensaje              ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
            $arrayPromocion['error'] = $strMensaje;
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayPromocion,
                                            'succes'    => $boolSucces
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'createPuntoGlobal'
     * Método encargado de crear todos los puntos globales según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 20-09-2019
     * 
     * @return array  $objResponse
     */
    public function createPuntoGlobal($arrayData)
    {
        $strEstado          = $arrayData['estado'] ? $arrayData['estado']:'PENDIENTE';
        $intCantPuntos      = $arrayData['cantPuntos'] ? $arrayData['cantPuntos']:'';
        $intIdCliente       = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $strUsuarioCreacion = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual  = new \DateTime('now');
        $strMensajeError    = '';
        $strStatus          = 400;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $objCliente = $em->getRepository('AppBundle:InfoCliente')->find($intIdCliente);
            if(!is_object($objCliente) || empty($objCliente))
            {
                throw new \Exception('No existe el cliente con identificador enviada por parámetro.');
            }

            $entityCltPunto = new InfoClientePuntoGlobal();
            $entityCltPunto->setCLIENTEID($objCliente);
            $entityCltPunto->setCANTIDADPUNTOS($intCantPuntos);
            $entityCltPunto->setESTADO(strtoupper($strEstado));
            $entityCltPunto->setUSRCREACION($strUsuarioCreacion);
            $entityCltPunto->setFECREACION($strDatetimeActual);
            $em->persist($entityCltPunto);
            $em->flush();
            $strMensajeError = 'Punto creado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError ="Fallo al crear el Punto, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
            $arrayCltPunto = array('id'             => $entityCltPunto->getId(),
                                  'cantPuntos'      => $entityCltPunto->getCANTIDADPUNTOS(),
                                  'estado'          => $entityCltPunto->getESTADO(),
                                  'usrCreacion'     => $entityCltPunto->getUSRCREACION(),
                                  'feCreacion'      => $entityCltPunto->getFECREACION()
                                );
        }
        $arrayCltPunto['strMensajeError'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayCltPunto,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
}
