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
        }
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
                              'feModificacion' => $entityCliente->getUSRCREACION(),
                              'mensaje'        => $strMensajeError);
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
}

