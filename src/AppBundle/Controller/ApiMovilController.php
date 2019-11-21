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
use AppBundle\Entity\InfoClienteEncuesta;
use AppBundle\Entity\InfoPromocionHistorial;
use AppBundle\Entity\InfoVistaPublicidad;
use AppBundle\Entity\AdmiTipoComida;
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
               case 'getRestaurante':$arrayRespuesta = $this->getRestaurante($arrayData);
               break;
               case 'getEncuesta':$arrayRespuesta = $this->getEncuesta($arrayData);
               break;
               case 'getPregunta':$arrayRespuesta = $this->getPregunta($arrayData);
               break;
               /*
                        [INI]FLUJO DEL MOVIL CREAR PUNTOS
               */
               case 'getSucursalPorUbicacion':$arrayRespuesta = $this->getSucursalPorUbicacion($arrayData);//0
               break;
               case 'createContenido':$arrayRespuesta = $this->createContenido($arrayData);//1
               break;
               case 'createRespuesta':$arrayRespuesta = $this->createRespuesta($arrayData);//2
               break;
               case 'editContenido':$arrayRespuesta = $this->editContenido($arrayData);//3
               break;
               /*
                        [FIN]FLUJO DEL MOVIL CREAR PUNTOS
               */
               case 'getLoginMovil':$arrayRespuesta = $this->getLoginMovil($arrayData);
               break;
               case 'getPublicidad':$arrayRespuesta = $this->getPublicidad($arrayData);
               break;
               case 'createLike':$arrayRespuesta = $this->createLike($arrayData);
               break;
               case 'deleteLike':$arrayRespuesta = $this->deleteLike($arrayData);
               break;
               case 'createRedesSociales':$arrayRespuesta = $this->createRedesSociales($arrayData);
               break;
               case 'getPromocion':$arrayRespuesta = $this->getPromocion($arrayData);
               break;
               case 'createPromocionHistorial':$arrayRespuesta = $this->createPromocionHistorial($arrayData);
               break;
               case 'getTipoComida':$arrayRespuesta = $this->getTipoComida($arrayData);
               break;
               case 'editPromocionHistorial':$arrayRespuesta = $this->editPromocionHistorial($arrayData);
               break;
               case 'getCantPtosResEnc':$arrayRespuesta = $this->getCantPtosResEnc($arrayData);
               break;
               case 'generarPass':$arrayRespuesta = $this->generarPass($arrayData);
               break;
               case 'createPunto':$arrayRespuesta = $this->createPunto($arrayData);//Obsoleto
               break;
               case 'createPuntoGlobal':$arrayRespuesta = $this->createPuntoGlobal($arrayData);//Obsoleto
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
        $strEstado          = (!empty($strAutenticacionRS) && $strAutenticacionRS == 'N') ? 'INACTIVO':'ACTIVO';
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
            if($strAutenticacionRS == 'N')
            {
                $strDistractor     = substr(md5(time()),0,16);
                //$strActivaCltLocal = "http://127.0.0.1/bitteBackEnd/web/editCliente?jklasdqweuiorenm=".$strDistractor.$entityCliente->getId();
                $strActivaCltProd  = "http://bitte.app/bitteCore/web/editCliente?jklasdqweuiorenm=".$strDistractor.$entityCliente->getId();
                $strAsunto        = 'Bienvenido al mundo BITTE';
                $strMensajeCorreo = '<div class="">Bienvenido al mundo BITTE:</div>
                <div class="">&nbsp;</div>
                <div class="">BITTE le da la bienvenida a su sistema de an&aacute;lisis de datos de satisfacci&oacute;n cliente. BITE le va a permitir conocer la satisfacci&oacute;n de sus clientes bajo diferentes variables y a su vez le permitir&aacute; hacer distintos comparativos para conocer el impacto de mejoras que implemente en su restaurante. A su vez, BITTE permite a los usuarios del app compartir imagenes en redes sociales, que permitir&aacute;n a su establecimiento tener un marketing viral, tanto los datos de veces compartidas las imagen como el alcance de cada imagen, son datos estad&iacute;sticos, que dependiendo de su plan, su restaurante podr&aacute; conocer.&nbsp;</div>
                <div class="">&nbsp;</div>
                <div class="">Es hora de premiar a su clientela fija reconoci&eacute;ndolos con premios que usted ya estableci&oacute; y podr&aacute; controlar, permitiendo crear un vinculo mas cercano con sus clientes.&nbsp;</div>
                <div class="">&nbsp;</div>
                <div class="">Nuestro equipo de asistencia estar&aacute; disponible para usted para lo que necesite. Por favor complete su registro de establecimiento y comience a recolectar las opiniones de sus clientes de manera ordenada para un an&aacute;lisis y tabulaci&oacute;n din&aacute;mica.&nbsp;</div>
                <div class="">&nbsp;</div>
                <div class="">
                <div>
                <div><strong>Estás a un paso de comenzar, solamente debes activar tu cuenta.&nbsp;</strong></div>
                <div><a href='.$strActivaCltProd.' target="_blank" >Activar mi cuenta</a></div>
                <div>&nbsp;</div>
                </div>
                </div>
                <div class="">Bienvenido al mundo BITTE.</div>';
                $strRemitente     = 'notificaciones_bitte@massvision.tv';
                $arrayParametros  = array('strAsunto'          => $strAsunto,
                                            'strMensajeCorreo' => $strMensajeCorreo,
                                            'strRemitente'     => $strRemitente,
                                            'strDestinatario'  => $strCorreo);
                $objController    = new DefaultController();
                $objController->setContainer($this->container);
                $objController->enviaCorreo($arrayParametros);
            }
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
        $objResponse->setContent(json_encode(array( 'status'    => $strStatus,
                                                    'resultado' => $strMensajeError,
                                                    'succes'    => true)));
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
     * @author Kevin Baque
     * @version 1.1 17-08-2019 se cambia el llamado de cant. puntos del movil por el web.
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
            $arrayCliente   = $this->getDoctrine()->getRepository('AppBundle:InfoCliente')->getClienteCriterio($arrayParametros);
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
     * @author Nestor Naula
     * @version 1.1 04-10-2019 -  Se agrega la imagen a las coordenadas
     * @since 1.0
     * 
     * @return array  $objResponse
     */
    public function getSucursalPorUbicacion($arrayData)
    {
        $intidSucursal     = $arrayData['intIdSucursal'] ? $arrayData['intIdSucursal']:'';
        $strLatitud        = $arrayData['latitud'] ? $arrayData['latitud']:'';
        $strLongitud       = $arrayData['longitud'] ? $arrayData['longitud']:'';
        $strEstado         = $arrayData['estado'] ? $arrayData['estado']:'';
        $conImagen         = $arrayData['imagen'] ? $arrayData['imagen']:'NO';
        $intIdCliente      = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $arraySucursal     = array();
        $strMensajeError   = '';
        $strStatus         = 400;
        $strMetros         = 0;
        $intIterador       = 0;
        $objResponse       = new Response;
        $strDescripcion    = 'CANTIDAD_DISTANCIA';
        $boolError         = false;
        $boolSucces        = true;
        $arrayRespuesta    = array();
        try
        {
            $arrayCltEncuesta = $this->getDoctrine()->getRepository('AppBundle:InfoClienteEncuesta')->getVigenciaEncuesta(array('intIdCliente'=>$intIdCliente,
                                                                                                                                'intIdSucursal'=>$intidSucursal));
            if(isset($arrayCltEncuesta['error']) && !empty($arrayCltEncuesta['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arraySucursal['error']);
            }
            if(isset($arrayCltEncuesta['resultados']) && intval($arrayCltEncuesta['resultados'][0]['CANTIDAD']) >0 )
            {
                $boolError = true;
                throw new \Exception("Estimado, ud. ya cuenta con una encuesta llena, solo es permitido una encuesta por día en el mismo restaurante.");
            }
            $objController   = new DefaultController();
            $objParametro    = $this->getDoctrine()->getRepository('AppBundle:AdmiParametro')->findOneBy(array('ESTADO'      => 'ACTIVO',
                                                                                                               'DESCRIPCION'  => $strDescripcion));
            $arrayParametros = array('latitud' => $strLatitud,
                                    'longitud' => $strLongitud,
                                    'estado'   => $strEstado,
                                    'metros'   => $objParametro->getVALOR2()
                                    );
            $arraySucursal   = $this->getDoctrine()->getRepository('AppBundle:InfoSucursal')->getSucursalPorUbicacion($arrayParametros);
            foreach ($arraySucursal["resultados"] as &$item)
            {
                $arraySucursalRes   = $this->getDoctrine()->getRepository('AppBundle:InfoSucursal')
                                                          ->findOneById($item["ID_SUCURSAL"]);

                $arrayParametrosRes = array('intIdRestaurante'      => $arraySucursalRes->getRESTAURANTEID());
                $arrayRestaurante   = $this->getDoctrine()->getRepository('AppBundle:InfoRestaurante')->getRestauranteCriterioMovil($arrayParametrosRes);
                
                if($conImagen == 'SI')
                {
                    if(!empty($arrayRestaurante["resultados"]['IMAGEN']))
                    {
                        $arraySucursal["resultados"][$intIterador]["IMAGEN"] = $objController->getImgBase64($arrayRestaurante["resultados"]['IMAGEN']);
                    }
                    else
                    {
                        $arraySucursal["resultados"][$intIterador]["IMAGEN"] =  null;
                    }
                } 
                $intIterador = $intIterador +1;
            }
            
            if(isset($arraySucursal['error']) && !empty($arraySucursal['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arraySucursal['error']);
            }
        }
        catch(\Exception $ex)
        {
            if($boolError)
            {
                $strMensajeError = $ex->getMessage();
            }
            else
            {
                $strMensajeError ="Falló al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
            }
            $boolSucces = false;
        }
        $arraySucursal['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arraySucursal,
                                            'succes'    => $boolSucces
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
     * @author Kevin Baque
     * @version 1.1 17-1-2019 - Se agrega insert a la tabla InfovistaPublicidad.
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
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
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
        /*if($conImagen == 'SI')
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
        }*/
        $objParametro    = $this->getDoctrine()->getRepository('AppBundle:AdmiParametro')->findOneBy(array('ESTADO'      => 'ACTIVO',
                                                                                                           'DESCRIPCION'  => 'NUM_PUBLICIDAD'));
        if(!is_object($objParametro) || empty($objParametro))
        {
            throw new \Exception('No existe parametrizado el número de publicidad.');
        }
        $arrayResultado = array();
        foreach($arrayRestaurante['resultados'] as &$arrayItemRestaurante)
        {
            /*if($intContadorRes == $objParametro->getVALOR1())
            {
                $arrayPublicidad = (array) $this->getDoctrine()->getRepository('AppBundle:InfoPublicidad')->getPublicidadCriterioMovil(array('GENERO' => 'TODOS'));
                if(empty($arrayPublicidad))
                {
                    $arrayItemRestaurante['ES_PUBLICIDAD'] = 'N';
                }
                else
                {
                    $arrayResultado ['resultados'] []= array('NOMBRE_COMERCIAL' =>   $arrayPublicidad['resultados'][0]['DESCRIPCION'],
                                                             'ICONO'            =>   (!empty($arrayPublicidad['resultados'][0]['IMAGEN']) && $conIcono == 'SI')? $objController->getImgBase64($arrayPublicidad['resultados'][0]['IMAGEN']) :null,
                                                             'ES_PUBLICIDAD'    =>  'S');
                    $intContadorRes                  = 0;
                    if((!empty($intIdRestaurante) && !empty($intIdCliente)) && (!empty($arrayPublicidad['resultados'][0]['ID_PUBLICIDAD'])))
                    {
                        $entityVistaPubl = new InfoVistaPublicidad();
                        $entityVistaPubl->setCLIENTEID($em->getRepository('AppBundle:InfoCliente')->find($intIdCliente));
                        $entityVistaPubl->setRESTAURANTEID($em->getRepository('AppBundle:InfoRestaurante')->find($intIdRestaurante));
                        $entityVistaPubl->setPUBLICIDADID($em->getRepository('AppBundle:InfoPublicidad')->find($arrayPublicidad['resultados'][0]['ID_PUBLICIDAD']));
                        $entityVistaPubl->setESTADO(strtoupper('ACTIVO'));
                        $entityVistaPubl->setUSRCREACION($strUsuarioCreacion);
                        $entityVistaPubl->setFECREACION($strDatetimeActual);
                        $em->persist($entityVistaPubl);
                        $em->flush();
                    }
                }
            }*/
            //$intContadorRes ++;
            $arrayResultado ['resultados'] []= array('ID_RESTAURANTE'          =>   $arrayItemRestaurante['ID_RESTAURANTE'],
                                                     'TIPO_IDENTIFICACION'     =>   $arrayItemRestaurante['TIPO_IDENTIFICACION'],
                                                     'IDENTIFICACION'          =>   $arrayItemRestaurante['IDENTIFICACION'],
                                                     'RAZON_SOCIAL'            =>   $arrayItemRestaurante['RAZON_SOCIAL'],
                                                     'NOMBRE_COMERCIAL'        =>   $arrayItemRestaurante['NOMBRE_COMERCIAL'],
                                                     'REPRESENTANTE_LEGAL'     =>   $arrayItemRestaurante['REPRESENTANTE_LEGAL'],
                                                     'TIPO_COMIDA_ID'          =>   $arrayItemRestaurante['TIPO_COMIDA_ID'],
                                                     'DESCRIPCION_TIPO_COMIDA' =>   $arrayItemRestaurante['DESCRIPCION_TIPO_COMIDA'],
                                                     'DIRECCION_TRIBUTARIO'    =>   $arrayItemRestaurante['DIRECCION_TRIBUTARIO'],
                                                     'URL_CATALOGO'            =>   $arrayItemRestaurante['URL_CATALOGO'],
                                                     'NUMERO_CONTACTO'         =>   $arrayItemRestaurante['NUMERO_CONTACTO'],
                                                     'ESTADO'                  =>   $arrayItemRestaurante['ESTADO'],
                                                     //'IMAGEN'                  =>   $arrayItemRestaurante['IMAGEN'],
                                                     'IMAGEN'                  =>   (!empty($arrayItemRestaurante['IMAGEN']) && $conImagen == 'SI')? $objController->getImgBase64($arrayItemRestaurante['IMAGEN']) :null,
                                                     'ICONO'                   =>   (!empty($arrayItemRestaurante['ICONO']) && $conIcono == 'SI')? $objController->getImgBase64($arrayItemRestaurante['ICONO']) :null,
                                                     //'ICONO'                   =>   $arrayItemRestaurante['ICONO'],
                                                     'CANT_LIKE'               =>   $arrayItemRestaurante['CANT_LIKE'],
                                                     'PRO_ENCUESTAS'           =>   $arrayItemRestaurante['PRO_ENCUESTAS'],
                                                     'ID_LIKE'                 =>   $arrayItemRestaurante['ID_LIKE'] ? $arrayItemRestaurante['ID_LIKE']:null,
                                                     'ES_PUBLICIDAD'           =>  'N');
        }
        $arrayResultado['error'] = $strMensajeError;
        $em->getConnection()->commit();
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayResultado,
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
            $arrayParametros = array('ESTADO'         => $strEstado);
            $objEncuesta     = $em->getRepository('AppBundle:InfoEncuesta')->findBy($arrayParametros);            
            if(empty($objEncuesta) && !is_array($objEncuesta))
            {
                throw new \Exception('La encuesta a buscar no existe.');
            }
            foreach($objEncuesta as $arrayItem)
            {
                $arrayParametrosPreg = array('ESTADO'     => 'ACTIVO',
                                             'ENCUESTA_ID' => $arrayItem->getId());
                $objPregunta         = $em->getRepository('AppBundle:InfoPregunta')->findBy($arrayParametrosPreg);
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
                                        'idEncuesta'          => $arrayItem->getId(),
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
     * Adicional crear las relaciones entre clt. y encuestas.
     * 
     * @author Kevin Baque
     * @version 1.0 04-09-2019
     * 
     * @return array  $objResponse
     */
    public function createRespuesta($arrayData)
    {
        date_default_timezone_set('America/Guayaquil');
        $intIdCliente       = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $intIdSucursal      = $arrayData['idSucursal'] ? $arrayData['idSucursal']:'';
        $intIdEncuesta      = $arrayData['idEncuesta'] ? $arrayData['idEncuesta']:'';
        $intIdPregunta      = $arrayData['idPregunta'] ? $arrayData['idPregunta']:'';
        $intIdContenido     = $arrayData['idContenido'] ? $arrayData['idContenido']:'';
        $strRespuesta       = $arrayData['respuesta'] ? $arrayData['respuesta']:'';
        $arrayPregunta      = $arrayData['arrayPregunta'] ? $arrayData['arrayPregunta']:'';
        $strEstado          = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $strUsuarioCreacion = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual  = new \DateTime('now');
        $arrayRespuesta     = array();
        $strEstadoPendiente = 'PENDIENTE';
        $strMensajeError    = '';
        $strStatus          = 400;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        $boolSucces         = true;
        try
        {
            $em->getConnection()->beginTransaction();
            $objCliente     = $em->getRepository('AppBundle:InfoCliente')->find($intIdCliente);
            if(!is_object($objCliente) || empty($objCliente))
            {
                throw new \Exception('No existe el cliente con la descripción enviada por parámetro.');
            }
            $objSucursal = $em->getRepository('AppBundle:InfoSucursal')->find($intIdSucursal);
            if(!is_object($objSucursal) || empty($objSucursal))
            {
                throw new \Exception('No existe la sucursal con la descripción enviada por parámetro.');
            }
            $objEncuesta   = $em->getRepository('AppBundle:InfoEncuesta')->find($intIdEncuesta);
            if(!is_object($objEncuesta) || empty($objEncuesta))
            {
                throw new \Exception('No existe la Encuesta con la descripción enviada por parámetro.');
            }
            $objContenido    = $em->getRepository('AppBundle:InfoContenidoSubido')->find($intIdContenido);
            if(!is_object($objContenido) || empty($objContenido))
            {
                throw new \Exception('No existe el contenido con la descripción enviada por parámetro.');
            }
            $objParametro    = $em->getRepository('AppBundle:AdmiParametro')->findOneBy(array('DESCRIPCION' => 'PUNTOS_ENCUESTA',
                                                                                              'ESTADO'      => 'ACTIVO'));
            if(!is_object($objParametro) || empty($objParametro))
            {
                throw new \Exception('No existe puntos de encuesta con la descripción enviada por parámetro.');
            }
            $entityCltEncuesta = new InfoClienteEncuesta();
            $entityCltEncuesta->setCLIENTEID($objCliente);
            $entityCltEncuesta->setSUCURSALID($objSucursal);
            $entityCltEncuesta->setENCUESTAID($objEncuesta);
            $entityCltEncuesta->setESTADO(strtoupper($strEstadoPendiente));
            $entityCltEncuesta->setCONTENIDOID($objContenido);
            $entityCltEncuesta->setUSRCREACION($strUsuarioCreacion);
            $entityCltEncuesta->setFECREACION($strDatetimeActual);
            $entityCltEncuesta->setCANTIDADPUNTOS($objParametro->getVALOR1());

            $em->persist($entityCltEncuesta);
            $em->flush();
            $intIdCltEncuesta = $entityCltEncuesta->getId();
            if(empty($intIdCltEncuesta))
            {
                $em->getConnection()->rollback();
                throw new \Exception('No ingreso la relación entre Cliente y encuesta, con la descripción enviada por parámetro.');
            }
            else
            {
                if ($em->getConnection()->isTransactionActive())
                {
                    $em->getConnection()->commit();
                    $em->getConnection()->close();
                }
                $objCltEncuesta  = $em->getRepository('AppBundle:InfoClienteEncuesta')->find($intIdCltEncuesta);
                if(!is_object($objCltEncuesta) || empty($objCltEncuesta))
                {
                    throw new \Exception('No existe la relación cliente encuesta con la descripción enviada por parámetro.');
                }
                foreach ($arrayPregunta as $intIdPregunta => $strRespuesta) 
                {
                    $arrayParametrosPreg = array('ESTADO' => 'ACTIVO',
                                                 'id'     => $intIdPregunta);
                    $objPregunta    = $em->getRepository('AppBundle:InfoPregunta')->findOneBy($arrayParametrosPreg);
                    if(!is_object($objPregunta) || empty($objPregunta))
                    {
                        throw new \Exception('No existe la pregunta con la descripción enviada por parámetro.');
                    }
                    $entityRespuesta = new InfoRespuesta();
                    $entityRespuesta->setRESPUESTA($strRespuesta);
                    $entityRespuesta->setPREGUNTAID($objPregunta);
                    $entityRespuesta->setCLTENCUESTAID($objCltEncuesta);
                    $entityRespuesta->setCLIENTEID($objCliente);
                    $entityRespuesta->setESTADO(strtoupper($strEstado));
                    $entityRespuesta->setUSRCREACION($strUsuarioCreacion);
                    $entityRespuesta->setFECREACION($strDatetimeActual);
                    $em->persist($entityRespuesta);
                    $em->flush();
                    /*$arrayRespuesta ['respuesta'][] = array('idRespuesta'     => $entityRespuesta->getId(),
                                                            'intIdCltEncuesta'=> $intIdCltEncuesta,
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
                                                            'feModificacion'  => $entityRespuesta->getFECREACION());*/
                }
                $strMensajeError = 'Respuesta creada con exito.!';
            }
        }
        catch(\Exception $ex)
        {
            $boolSucces = false;
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
        }
        $arrayRespuesta['mensaje']          = $strMensajeError;
        $arrayRespuesta['intIdCltEncuesta'] = $intIdCltEncuesta;
        $objResponse->setContent(json_encode(array(
                                                    'status'           => $strStatus,
                                                    'objSucursal'=>$objSucursal,
                                                    'resultado'        => $arrayRespuesta,
                                                    'succes'           => $boolSucces
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
            $arrayParametros = array('CORREO' => $strCorreo,
                                     'ESTADO' => 'ACTIVO');
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
     * @author Kevin Baque
     * @version 1.1 17-1-2019 - Se agrega insert a la tabla InfovistaPublicidad.
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
        $boolSucces             = true;
        $strDatetimeActual      = new \DateTime('now');
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        $objController    = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            $em->getConnection()->beginTransaction();
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
            $strStatus  = 404;
            $boolSucces = false;
            if ($em->getConnection()->isTransactionActive())
            {
                $em->getConnection()->rollback();
            }
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
            if((!empty($objCliente) && is_object($objCliente)) && (!empty($objSucursal) && is_object($objSucursal)))
            {
                $entityVistaPubl = new InfoVistaPublicidad();
                $entityVistaPubl->setCLIENTEID($objCliente);
                $entityVistaPubl->setRESTAURANTEID($objSucursal->getRESTAURANTEID());
                $entityVistaPubl->setPUBLICIDADID($em->getRepository('AppBundle:InfoPublicidad')->find($item['ID_PUBLICIDAD']));
                $entityVistaPubl->setESTADO(strtoupper('ACTIVO'));
                $entityVistaPubl->setUSRCREACION($strUsuarioCreacion);
                $entityVistaPubl->setFECREACION($strDatetimeActual);
                $em->persist($entityVistaPubl);
                $em->flush();
                $em->getConnection()->commit();
            }
            if(!empty($item['IMAGEN']) && $conImagen == 'SI')
            {
                $arrayPublicidadMovil['IMAGEN'] = $objController->getImgBase64($item['IMAGEN']);
            }
        }
        $objResponse->setContent(json_encode(array(
                                                    'status'    => $strStatus,
                                                    'resultado' => $arrayPublicidadMovil,
                                                    'succes'    => $boolSucces)
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
     * Documentación para la función 'editContenido'
     * Método encargado de editar todos los contenidos según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 02-10-2019
     * 
     * @return array  $objResponse
     */
    public function editContenido($arrayData)
    {
        $intIdContenido     = $arrayData['idContenido'] ? $arrayData['idContenido']:'';
        $intIdRedSocial     = $arrayData['idRedSocial'] ? $arrayData['idRedSocial']:'NO COMPARTIDO';
        $strUsuarioCreacion = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual  = new \DateTime('now');
        $strMensajeError    = '';
        $strStatus          = 400;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        $boolSucces         = true;
        try
        {
            $em->getConnection()->beginTransaction();
            $objContenido = $em->getRepository('AppBundle:InfoContenidoSubido')->find($intIdContenido);
            if(!is_object($objContenido) || empty($objContenido))
            {
                throw new \Exception('No existe el contenido con identificador enviada por parámetro.');
            }
            $objParametro    = $em->getRepository('AppBundle:AdmiParametro')->findOneBy(array('DESCRIPCION' => 'PUNTOS_PUBLICACION',
                                                                                              'ESTADO'      => 'ACTIVO'));
            if(!is_object($objParametro) || empty($objParametro))
            {
                throw new \Exception('No existe puntos de encuesta con la descripción enviada por parámetro.');
            }
            $objRedSocial = $em->getRepository('AppBundle:InfoRedesSociales')->findOneBy(array('id'     => $intIdRedSocial,
                                                                                               'ESTADO' => 'ACTIVO'));
            if(!is_object($objRedSocial) || empty($objRedSocial))
            {
                throw new \Exception('No existe la red social con identificador enviada por parámetro.');
            }
            else
            {
                $objContenido->setREDESSOCIALESID($objRedSocial);
                $objContenido->setCANTIDADPUNTOS($objParametro->getVALOR1());
                $objContenido->setUSRMODIFICACION($strUsuarioCreacion);
                $objContenido->setFEMODIFICACION($strDatetimeActual);
                $em->persist($objContenido);
                $em->flush();
                $strMensajeError = 'Contenido editado con exito.!';
            }
        }
        catch(\Exception $ex)
        {
            $boolSucces         = false;
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError ="Fallo al editar el Contenido, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
            $arrayContenido = array('id'            => $objContenido->getId(),
                                  'descripcion'     => $objContenido->getDESCRIPCION(),
                                  'cantPuntos'      => $objContenido->getCANTIDADPUNTOS(),
                                  'estado'          => $objContenido->getESTADO(),
                                  'usrCreacion'     => $objContenido->getUSRCREACION(),
                                  'feCreacion'      => $objContenido->getFECREACION());
        }
        $arrayContenido['strMensajeError'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayContenido,
                                            'succes'    => $boolSucces
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
        $intIdRedSocial     = $arrayData['idRedSocial'] ? $arrayData['idRedSocial']:'NO COMPARTIDO';
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
        $boolSucces         = true;
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
            $objRedSocial = $em->getRepository('AppBundle:InfoRedesSociales')->findOneBy(array('DESCRIPCION' => $intIdRedSocial,
                                                                                               'ESTADO'      => 'ACTIVO'));
            if(!is_object($objRedSocial) || empty($objRedSocial))
            {
                throw new \Exception('No existe la red social con identificador enviada por parámetro.');
            }
            $entityContSub = new InfoContenidoSubido();
            $entityContSub->setCLIENTEID($objCliente);
            $entityContSub->setREDESSOCIALESID($objRedSocial);
            $entityContSub->setDESCRIPCION($strDescripcion);
            $entityContSub->setIMAGEN($strRutaImagen);
            $entityContSub->setESTADO(strtoupper($strEstado));
            $entityContSub->setUSRCREACION($strUsuarioCreacion);
            $entityContSub->setFECREACION($strDatetimeActual);
            $entityContSub->setCANTIDADPUNTOS(0);
            $em->persist($entityContSub);
            $em->flush();
            $strMensajeError = 'Contenido creado con exito.!';
        }
        catch(\Exception $ex)
        {
            $boolSucces         = false;
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
                                            'succes'    => $boolSucces
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

            $entityRedesSociales = new InfoRedesSociales();
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
     * @author Kevin Baque
     * @version 1.1 10-11-2019 Se agrega filtro por restaurante.
     *
     * @return array  $objResponse
     */
    public function getPromocion($arrayData)
    {
        $intIdSucursal          = $arrayData['idSucursal'] ? $arrayData['idSucursal']:'';
        $intIdRestaurante       = $arrayData['intIdRestaurante'] ? $arrayData['intIdRestaurante']:'';
        $intIdCliente           = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
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
        $intCantPuntos          = 0;
        $objController->setContainer($this->container);
        try
        {
            $objPromocion     = $em->getRepository('AppBundle:InfoPromocion')->findBy(array('ESTADO'         => $strEstado,
                                                                                            'PREMIO'         => 'NO',
                                                                                            'RESTAURANTE_ID' => $intIdRestaurante));
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
                                        'cantPuntos'       => $arrayItem->getCANTIDADPUNTOS(),
                                        'aceptaGlobal'     => $arrayItem->getACEPTAGLOBAL(),
                                        'estado'           => $arrayItem->getESTADO());
            }
            $arrayPuntos     = $em->getRepository('AppBundle:InfoClientePunto')->findBy(array('RESTAURANTE_ID' => $intIdRestaurante,
                                                                                              'CLIENTE_ID'  => $intIdCliente));
            if(empty($arrayPuntos) && !is_array($arrayPuntos))
            {
                $intCantPuntos = 0;
            }
            else
            {
                foreach($arrayPuntos as $arrayItemPuntos)
                {
                    $intCantPuntos = $intCantPuntos + $arrayItemPuntos->getCANTIDADPUNTOS();
                }
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
                                            'puntaje'   => $intCantPuntos,
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
    /**
     * Documentación para la función 'createPromocionHistorial'
     * Método encargado de crear el historial de las promociones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 29-09-2019
     * 
     * @return array  $objResponse
     */
    public function createPromocionHistorial($arrayData)
    {
        $intIdPromocion     = $arrayData['idPromocion'] ? $arrayData['idPromocion']:'';
        $intIdCliente       = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $intIdRestaurante   = $arrayData['idRestaurante'] ? $arrayData['idRestaurante']:'';
        $strEstado          = $arrayData['estado'] ? $arrayData['estado']:'PENDIENTE';
        $strUsuarioCreacion = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual  = new \DateTime('now');
        $strMensajeError    = '';
        $strStatus          = 400;
        $intCantidadPuntos  = 0;
        $intCantPuntospromo = 0;
        $objResponse        = new Response;
        $em                 = $this->getDoctrine()->getEntityManager();
        $boolSucces         = true;
        try
        {
            $em->getConnection()->beginTransaction();
            $objCliente = $em->getRepository('AppBundle:InfoCliente')->find($intIdCliente);
            if(!is_object($objCliente) || empty($objCliente))
            {
                throw new \Exception('No existe el cliente con identificador enviada por parámetro.');
            }
            //consultar el estado a buscar
            $arrayCltPunto = $em->getRepository('AppBundle:InfoClientePunto')->findBy(array('CLIENTE_ID'     => $intIdCliente,
                                                                                            'RESTAURANTE_ID' => $intIdRestaurante));
            if(!is_array($arrayCltPunto) || empty($arrayCltPunto))
            {
                throw new \Exception('No tiene puntaje sufuciente.');
            }
            foreach($arrayCltPunto as $arrayItem)//1REGISTRO
            {
                $intCantidadPuntos = $intCantidadPuntos + $arrayItem->getCANTIDADPUNTOS();
            }
            $objPromocion = $em->getRepository('AppBundle:InfoPromocion')->find($intIdPromocion);
            if(!is_object($objPromocion) || empty($objPromocion))
            {
                throw new \Exception('No existe la Promoción.');
            }
            $intCantPuntospromo = $objPromocion->getCANTIDADPUNTOS();
            if($intCantPuntospromo<=$intCantidadPuntos)
            {
                $arrayPromociones   = $this->getDoctrine()->getRepository('AppBundle:InfoPromocionHistorial')
                                        ->getPromoHistorialCriterio(array('intIdCliente'=>$intIdCliente,
                                                                          'strEstado'   =>'PENDIENTE'));
                if(isset($arrayPromociones['error']) && !empty($arrayPromociones['error']))
                {
                    $strStatus  = 404;
                    throw new \Exception($arrayPromociones['error']);
                }
                $intCantidadPromocion = $arrayPromociones['resultados'];
                //(puntajeCliente-puntjaePromocionesVigente) > puntajePromocion
                $intSumaPuntajeClt    = $intCantidadPuntos - $intCantidadPromocion;
                if($intSumaPuntajeClt >= $intCantPuntospromo)
                {
                    $entityPromocionHist = new InfoPromocionHistorial();
                    $entityPromocionHist->setCLIENTEID($objCliente);
                    $entityPromocionHist->setPROMOCIONID($objPromocion);
                    $entityPromocionHist->setESTADO(strtoupper($strEstado));
                    $entityPromocionHist->setUSRCREACION($strUsuarioCreacion);
                    $entityPromocionHist->setFECREACION($strDatetimeActual);
                    $em->persist($entityPromocionHist);
                    $em->flush();
                    $strMensajeError = 'Creado con exito.!';
                }
                else
                {
                    $intResultado = $intCantPuntospromo - $intCantidadPuntos;
                    throw new \Exception('Puntaje reservado. Se está procesando una promoción.');
                }
            }
            else
            {
                $intResultado = $intCantPuntospromo - $intCantidadPuntos;
                throw new \Exception('Cantidad de puntos insuficiente. Al momento ud. cuenta con '.$intCantidadPuntos.' puntos, por lo cual le hace falta: '.$intResultado.' puntos.');
            }
        }
        catch(\Exception $ex)
        {
            $boolSucces = false;
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
            $arrayPromocionHist = array('id'             => $entityPromocionHist->getId(),
                                        'idCliente'      => $entityPromocionHist->getCLIENTEID()->getId(),
                                        'idPromocion'    => $entityPromocionHist->getPROMOCIONID()->getId(),
                                        'estado'         => $entityPromocionHist->getESTADO(),
                                        'usrCreacion'    => $entityPromocionHist->getUSRCREACION(),
                                        'feCreacion'     => $entityPromocionHist->getFECREACION()
                                );
        }
        $arrayPromocionHist['strMensajeError'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayPromocionHist,
                                            'succes'    => $boolSucces
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'getTipoComida'
     * Método encargado de listar los tipos de comida según los parámetros recibidos.
     *
     * @author Kevin Baque
     * @version 1.0 15-10-2019
     *
     * @return array  $objResponse
     */
    public function getTipoComida($arrayData)
    {
        $intIdTipoComida        = $arrayData['idTipoComida'] ? $arrayData['idTipoComida']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $boolSucces             = true;
        $arrayTipoComida        = array();
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        $objController          = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            $arrayParametros = array('ESTADO' => $strEstado);
            if(!empty($intIdTipoComida))
            {
                $arrayParametros['id'] = $intIdTipoComida;
            }
            $objTipoComida = $em->getRepository('AppBundle:AdmiTipoComida')->findBy($arrayParametros);
            if(empty($objTipoComida) && !is_array($objTipoComida))
            {
                throw new \Exception('El tipo de comida a buscar no existe.');
            }
            foreach($objTipoComida as $arrayItem)
            {
                $arrayTipoComida []= array('idTipoComida'     => $arrayItem->getId(),
                                           'descripcion'      => $arrayItem->getDESCRIPCION(),
                                           'estado'           => $arrayItem->getESTADO());
            }
        }
        catch(\Exception $ex)
        {
            $boolSucces               = false;
            $strStatus                = 404;
            $strMensaje               ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
            $arrayTipoComida['error'] = $strMensaje;
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayTipoComida,
                                            'succes'    => $boolSucces
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'editPromocionHistorial'
     * Método encargado de eliminar el historial de la promoción según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 28-10-2019
     * 
     * @return array  $objResponse
     */
    public function editPromocionHistorial($arrayData)
    {
        $intIdPromocionHist     = $arrayData['idPromocionHist'] ? $arrayData['idPromocionHist']:'';
        $strEstado              = $arrayData['estado'] ? $arrayData['estado']:'COMPLETADO';
        $strUsuarioCreacion     = $arrayData['usuarioCreacion'] ? $arrayData['usuarioCreacion']:'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $em                     = $this->getDoctrine()->getEntityManager();
        try
        {
            $em->getConnection()->beginTransaction();
            $objPromocionHist = $em->getRepository('AppBundle:InfoPromocionHistorial')->findOneBy(array('id'     => $intIdPromocionHist,
                                                                                                        'ESTADO' => 'PENDIENTE'));
            if(!is_object($objPromocionHist) || empty($objPromocionHist))
            {
                throw new \Exception('Promoción ha sido redimida.');
            }
            $em->remove($objPromocionHist);
            $em->flush();
            $strMensajeError = 'Historial de la promoción eliminada con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            $strMensajeError = "Fallo al eliminar Historial de la promoción, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $strMensajeError,
                                            'succes'    => true)
                                            ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'getCantPtosResEnc'
     * Método encargado de retornar todos los clientes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @author Kevin Baque
     * @version 1.1 11-11-2019 Se retorna el icono del restaurante, adicional se cambia el valor razon social por nombre comercial.
     * 
     * @return array  $objResponse
     */
    public function getCantPtosResEnc($arrayData)
    {
        $intIdCliente      = $arrayData['idCliente'] ? $arrayData['idCliente']:'';
        $strEstado         = $arrayData['estado'] ? $arrayData['estado']:'ACTIVO';
        $conIcono          = $arrayData['icono']  ? $arrayData['icono']:'SI';
        $arrayPuntos       = array();
        $strMensajeError   = '';
        $strStatus         = 400;
        $objResponse       = new Response;
        $objController     = new DefaultController();
        $objController->setContainer($this->container);
        try
        {
            $arrayParametros = array('intIdCliente'     => $intIdCliente,
                                    'strEstado'         => $strEstado
                                    );
            $arrayPuntos   = $this->getDoctrine()->getRepository('AppBundle:InfoClienteEncuesta')->getCantPtosResEnc($arrayParametros);
            if(isset($arrayPuntos['error']) && !empty($arrayPuntos['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayPuntos['error']);
            }
            if($conIcono == 'SI')
            {
                foreach ($arrayPuntos['resultados'] as &$item)
                {
                    if($item['ICONO'])
                    {
                        $item['ICONO'] = $objController->getImgBase64($item['ICONO']);
                    }
                }
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayPuntos['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayPuntos,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * Documentación para la función 'generarPass'
     * Método encargado de generar las contraseñas a todos los clientes.
     *
     * @author Kevin Baque
     * @version 1.0 14-11-2019
     *
     * @return array  $objResponse
     */
    public function generarPass($arrayData)
    {
        $strDestinatario  = $arrayData['strCorreo'] ? $arrayData['strCorreo']:'';
        $strAsunto        = 'Clave temporal Bitte';
        $strContrasenia   = uniqid();
        $strMensajeCorreo = '<div class="">Estimado cliente.</div>
        <div class="">&nbsp;</div>
        <div class="">En base a su solicitud el sistema BITTE ha procedido a asignarle una clave temporal.&nbsp;</div>
        <div class="">&nbsp;</div>
        <div><strong>Tu clave temporal es :'.$strContrasenia.'&nbsp;</strong></div>
        <div class="">&nbsp;</div>
        <div class="">Recuerda que para mayor seguridad luego de ingresar a BITTE es muy importante cambiar la contraseña.&nbsp;</div>
        <div class="">&nbsp;</div>
        <div class="">
        <div>
        <div class="">Nuestro equipo de asistencia estar&aacute; disponible para usted para lo que necesite.&nbsp;</div>
        <div>&nbsp;</div>
        </div>
        </div>
        <div class="">Bienvenido al mundo BITTE.</div>';
        $strRemitente     = 'notificaciones_bitte@massvision.tv';
        $objResponse      = new Response;
        $strRespuesta     = '';
        $arrayParametros  = array();
        $strStatus        = 400;
        $em               = $this->getDoctrine()->getEntityManager();
        $strMensajeError  = '';
        $boolSucces       = true;
        try
        {
            $em->getConnection()->beginTransaction();
            if(empty($strDestinatario))
            {
                throw new \Exception('Es necesario enviar el correo.');
            }
            $objCliente = $em->getRepository('AppBundle:InfoCliente')->findOneBy(array('CORREO'=>$strDestinatario));
            if(!is_object($objCliente) && empty($objCliente))
            {
                throw new \Exception('Cliente no existente.');
            }
            if(empty($strContrasenia))
            {
                throw new \Exception('No se ah generado la contraseña.');
            }
            $arrayParametros  = array('strAsunto'        => $strAsunto,
                                      'strMensajeCorreo' => $strMensajeCorreo,
                                      'strRemitente'     => $strRemitente,
                                      'strDestinatario'  => $strDestinatario);
            $objController    = new DefaultController();
            $objController->setContainer($this->container);
            $objController->enviaCorreo($arrayParametros);
            $objCliente->setCONTRASENIA(md5($strContrasenia));
            $em->persist($objCliente);
            $em->flush();
            $strMensajeError = 'Cambio de clave con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $em->getConnection()->rollback();
                $em->getConnection()->close();
            }
            $strStatus       = 404;
            $boolSucces      = false;
            $strMensajeError = "Fallo al generar el correo, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $strMensajeError,
                                            'succes'    => $boolSucces
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
}
