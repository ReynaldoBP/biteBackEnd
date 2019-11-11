<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoUsuario;
use AppBundle\Entity\AdmiTipoRol;
use AppBundle\Controller\DefaultController;

class UsuarioController extends Controller
{

    /**
     * @Route("/getUsuario")
     *
     * Documentación para la función 'getUsuario'
     * Método encargado de retornar todos los usuarios según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @author Kevin Baque
     * @version 1.1 10-11-2019 Se agrega filtro por restaurante.
     * 
     * @return array  $objResponse
     */
    public function getUsuarioAction(Request $request)
    {
        $intIdUsuario           = $request->query->get("idUsuario") ? $request->query->get("idUsuario"):'';
        $intIdRestaurante       = $request->query->get("intIdRestaurante") ? $request->query->get("intIdRestaurante"):'';
        $strTipoRol             = $request->query->get("idRol") ? $request->query->get("idRol"):'';
        $strIdentificacion      = $request->query->get("identificacion") ? $request->query->get("identificacion"):'';
        $strNombres             = $request->query->get("nombres") ? $request->query->get("nombres"):'';
        $strApellidos           = $request->query->get("apellidos") ? $request->query->get("apellidos"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $arrayUsuarios          = array();
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        try
        {
            $arrayParametros = array('intIdUsuario'     => $intIdUsuario,
                                    'strTipoRol'        => $strTipoRol,
                                    'strIdentificacion' => $strIdentificacion,
                                    'intIdRestaurante'  => $intIdRestaurante,
                                    'strNombres'        => $strNombres,
                                    'strApellidos'      => $strApellidos,
                                    'strEstado'         => $strEstado
                                    );
            $arrayUsuarios   = $this->getDoctrine()->getRepository('AppBundle:InfoUsuario')->getUsuariosCriterio($arrayParametros);
            if(isset($arrayUsuarios['error']) && !empty($arrayUsuarios['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayUsuarios['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strMensajeError ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $arrayUsuarios['error'] = $strMensajeError;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayUsuarios,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * @Route("/createUsuario")
     *
     * Documentación para la función 'createUsuario'
     * Método encargado de crear los usuarios según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function createUsuarioAction(Request $request)
    {
        $strTipoRol             = $request->query->get("idRol") ? $request->query->get("idRol"):'';
        $strIdentificacion      = $request->query->get("identificacion") ? $request->query->get("identificacion"):'';
        $strNombres             = $request->query->get("nombres") ? $request->query->get("nombres"):'';
        $strApellidos           = $request->query->get("apellidos") ? $request->query->get("apellidos"):'';
        $strContrasenia         = $request->query->get("contrasenia") ? $request->query->get("contrasenia"):'';
        $strImagen              = $request->query->get("imagen") ? $request->query->get("imagen"):'';
        $strCorreo              = $request->query->get("correo") ? $request->query->get("correo"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $strPais                = $request->query->get("pais") ? $request->query->get("pais"):'';
        $strCiudad              = $request->query->get("ciudad") ? $request->query->get("ciudad"):'';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        $strDescripcion='';
        try
        {
            $em->getConnection()->beginTransaction();
            $arrayParametrosRol = array('ESTADO' => 'ACTIVO',
                                        'id'     => $strTipoRol);
            $objTipoRol         = $em->getRepository('AppBundle:AdmiTipoRol')->findOneBy($arrayParametrosRol);
            if(!is_object($objTipoRol) || empty($objTipoRol))
            {
                throw new \Exception('No existe rol con la descripción enviada por parámetro.');
            }
            $objUsuario         = $em->getRepository('AppBundle:InfoUsuario')->findOneBy(array('IDENTIFICACION'=>$strIdentificacion));
            if(is_object($objUsuario) && !empty($objUsuario))
            {
                throw new \Exception('Usuario ya existente.');
            }
            $objUsuario         = $em->getRepository('AppBundle:InfoUsuario')->findOneBy(array('CORREO'=>$strCorreo));
            if(is_object($objUsuario) && !empty($objUsuario))
            {
                throw new \Exception('Usuario ya existente.');
            }
            $entityUsuario = new InfoUsuario();
            $entityUsuario->setTIPOROLID($objTipoRol);
            $entityUsuario->setIDENTIFICACION($strIdentificacion);
            $entityUsuario->setNOMBRES($strNombres);
            $entityUsuario->setAPELLIDOS($strApellidos);
            if(!empty($strContrasenia))
            {
                $entityUsuario->setCONTRASENIA(md5($strContrasenia));
            }
            $entityUsuario->setIMAGEN($strImagen);
            $entityUsuario->setCORREO($strCorreo);
            $entityUsuario->setESTADO(strtoupper($strEstado));
            $entityUsuario->setPAIS($strPais);
            $entityUsuario->setCIUDAD($strCiudad);
            $entityUsuario->setUSRCREACION($strUsuarioCreacion);
            $entityUsuario->setFECREACION($strDatetimeActual);
            $em->persist($entityUsuario);
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
            $strMensajeError = "Fallo al crear un Usuario, intente nuevamente.\n ". $ex->getMessage();
        }
        if ($em->getConnection()->isTransactionActive())
        {
            $em->getConnection()->commit();
            $em->getConnection()->close();
        }
        $arrayUsuario    = array('id'             => $entityUsuario->getId(),
                                 'identificacion' => $entityUsuario->getIDENTIFICACION(),
                                 'nombres'        => $entityUsuario->getNOMBRES(),
                                 'apellido'       => $entityUsuario->getAPELLIDOS(),
                                 'correo'         => $entityUsuario->getCORREO(),
                                 'estado'         => $entityUsuario->getESTADO(),
                                 'usrCreacion'    => $entityUsuario->getUSRCREACION(),
                                 'feCreacion'     => $entityUsuario->getFECREACION(),
                                 'mensaje'        => $strMensajeError);
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayUsuario,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * @Route("/editUsuario")
     *
     * Documentación para la función 'editUsuario'
     * Método encargado de editar los usuarios según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function editUsuarioAction(Request $request)
    {
        $strTipoRol             = $request->query->get("idRol") ? $request->query->get("idRol"):'';
        $intIdUsuario           = $request->query->get("idUsuario") ? $request->query->get("idUsuario"):'';
        $strIdentificacion      = $request->query->get("identificacion") ? $request->query->get("identificacion"):'';
        $strNombres             = $request->query->get("nombres") ? $request->query->get("nombres"):'';
        $strApellidos           = $request->query->get("apellidos") ? $request->query->get("apellidos"):'';
        $strContrasenia         = $request->query->get("contrasenia") ? $request->query->get("contrasenia"):'';
        $strImagen              = $request->query->get("imagen") ? $request->query->get("imagen"):'';
        $strCorreo              = $request->query->get("correo") ? $request->query->get("correo"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $strPais                = $request->query->get("pais") ? $request->query->get("pais"):'';
        $strCiudad              = $request->query->get("ciudad") ? $request->query->get("ciudad"):'';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        $strDescripcion='';
        try
        {
            $em->getConnection()->beginTransaction();
            $objUsuario = $em->getRepository('AppBundle:InfoUsuario')->findOneBy(array('id'=>$intIdUsuario));
            if(!is_object($objUsuario) || empty($objUsuario))
            {
                throw new \Exception('No existe usuario con la identificación enviada por parámetro.');
            }
            if(!empty($strTipoRol))
            {
                $arrayParametrosRol = array('ESTADO' => $strEstado,
                                            'id'     => $strTipoRol);
                $objTipoRol         = $em->getRepository('AppBundle:AdmiTipoRol')->findOneBy($arrayParametrosRol);
                if(!is_object($objTipoRol) || empty($objTipoRol))
                {
                    throw new \Exception('No existe rol con la descripción enviada por parámetro.');
                }
                $objUsuario->setTIPOROLID($objTipoRol);
            }
            if(!empty($strIdentificacion))
            {
                $objUsuario->setIDENTIFICACION($strIdentificacion);
            }
            if(!empty($strNombres))
            {
                $objUsuario->setNOMBRES($strNombres);
            }
            if(!empty($strApellidos))
            {
                $objUsuario->setAPELLIDOS($strApellidos);
            }
            if(!empty($strContrasenia))
            {
                $objUsuario->setCONTRASENIA(md5($strContrasenia));
            }
            if(!empty($strImagen))
            {
                $objUsuario->setIMAGEN($strImagen);
            }
            if(!empty($strCorreo))
            {
                $objUsuario->setCORREO($strCorreo);
            }
            if(!empty($strEstado))
            {
                $objUsuario->setESTADO(strtoupper($strEstado));
            }
            if(!empty($strPais))
            {
                $objUsuario->setPAIS($strPais);
            }
            if(!empty($strCiudad))
            {
                $objUsuario->setCIUDAD($strCiudad);
            }
            $objUsuario->setUSRMODIFICACION($strUsuarioCreacion);
            $objUsuario->setFEMODIFICACION($strDatetimeActual);
            $em->persist($objUsuario);
            $em->flush();
            $strMensajeError = 'Usuario editado con exito.!';
        }
        catch(\Exception $ex)
        {
            if ($em->getConnection()->isTransactionActive())
            {
                $strStatus = 404;
                $em->getConnection()->rollback();
            }
            
            $strMensajeError = "Fallo al editar un Usuario, intente nuevamente.\n ". $ex->getMessage();
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
     * @Route("/getLogin")
     *
     * Documentación para la función 'editUsuario'
     * Método encargado de verificar si ingresa a la plataforma Web según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function getLoginAction(Request $request)
    {
        $strCorreo     = $request->query->get("correo") ? $request->query->get("correo"):'';
        $strPass       = $request->query->get("contrasenia") ? $request->query->get("contrasenia"):'';
        $arrayUsuarios = array();
        $strMensaje    = '';
        $strStatus     = 400;
        $strSucces     = true;
        $objResponse   = new Response;
        try
        {
            $objUsuario   = $this->getDoctrine()->getRepository('AppBundle:InfoUsuario')->findBy(array('CORREO'      => $strCorreo,
                                                                                                       'CONTRASENIA' => md5($strPass)));
            if(empty($objUsuario))
            {
                $strStatus  = 404;
                $strSucces  = false;
                throw new \Exception('Usuario no existe.');
            }
            foreach($objUsuario as $objItemUsuario)
            {
                $arrayParametros = array('intIdUsuario'     => $objItemUsuario->getId(),
                                        'strTipoRol'        => $objItemUsuario->getTIPOROLID()->getId(),
                                        'strIdentificacion' => $objItemUsuario->getIDENTIFICACION(),
                                        'strNombres'        => $objItemUsuario->getNOMBRES(),
                                        'strApellidos'      => $objItemUsuario->getAPELLIDOS(),
                                        'strEstado'         => $objItemUsuario->getESTADO()
                                        );
            }
            $arrayUsuarios   = $this->getDoctrine()->getRepository('AppBundle:InfoUsuario')->getUsuariosCriterio($arrayParametros);
            if(isset($arrayUsuarios['error']) && !empty($arrayUsuarios['error']))
            {
                $strStatus  = 404;
                throw new \Exception($arrayUsuarios['error']);
            }
        }
        catch(\Exception $ex)
        {
            $strStatus = 404;
            $strMensaje = $ex->getMessage();
        }
        $arrayUsuarios['error'] = $strMensaje;
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayUsuarios,
                                            'succes'    => $strSucces
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * @Route("/generarPass")
     *
     * Documentación para la función 'generarPass'
     * Método encargado de generar las contraseñas a todos los usuarios.
     *
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     *
     * @return array  $objResponse
     */
    public function generarPassAction(Request $request)
    {
        $strDestinatario  = $request->query->get("correo") ? trim($request->query->get("correo")):'';
        $strAsunto        = 'Clave temporal Bitte';
        $strContrasenia   = uniqid();
        $strMensajeCorreo = '<div class="">Bienvenida Usuario Administrador Restaurante:</div>
        <div class="">&nbsp;</div>
        <div class="">BITTE le da la bienvenida a su sistema de an&aacute;lisis de datos de satisfacci&oacute;n cliente. BITE le va a permitir conocer la satisfacci&oacute;n de sus clientes bajo diferentes variables y a su vez le permitir&aacute; hacer distintos comparativos para conocer el impacto de mejoras que implemente en su restaurante. A su vez, BITTE permite a los usuarios del app compartir imagenes en redes sociales, que permitir&aacute;n a su establecimiento tener un marketing viral, tanto los datos de veces compartidas las imagen como el alcance de cada imagen, son datos estad&iacute;sticos, que dependiendo de su plan, su restaurante podr&aacute; conocer.&nbsp;</div>
        <div class="">&nbsp;</div>
        <div class="">Es hora de premiar a su clientela fija reconoci&eacute;ndolos con premios que usted ya estableci&oacute; y podr&aacute; controlar, permitiendo crear un vinculo mas cercano con sus clientes.&nbsp;</div>
        <div class="">&nbsp;</div>
        <div class="">Nuestro equipo de asistencia estar&aacute; disponible para usted para lo que necesite. Por favor complete su registro de establecimiento y comience a recolectar las opiniones de sus clientes de manera ordenada para un an&aacute;lisis y tabulaci&oacute;n din&aacute;mica.&nbsp;</div>
        <div class="">&nbsp;</div>
        <div class="">
        <div>
        <div><strong>Tu clave temporal es :'.$strContrasenia.'&nbsp;</strong></div>
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
        try
        {
            $em->getConnection()->beginTransaction();
            if(empty($strDestinatario))
            {
                throw new \Exception('Es necesario enviar el correo.');
            }
            $objUsuario = $em->getRepository('AppBundle:InfoUsuario')->findOneBy(array('CORREO'=>$strDestinatario));
            if(!is_object($objUsuario) && empty($objUsuario))
            {
                throw new \Exception('Usuario no existente.');
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
            $objUsuario->setCONTRASENIA(md5($strContrasenia));
            $em->persist($objUsuario);
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
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
}
