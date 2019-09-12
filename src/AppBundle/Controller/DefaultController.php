<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\InfoUsuario;
use Symfony\Component\HttpFoundation\Response;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
    /**
     * Documentación para la función 'enviaCorreo'
     * Método encargado de enviar correo según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 26-08-2019
     * 
     * @return array  $objResponse
     */
    public function enviaCorreo($arrayParametros)
    {
        $strAsunto        = $arrayParametros['strAsunto'] ? $arrayParametros['strAsunto']:'';
        $strMensajeCorreo = $arrayParametros['strMensajeCorreo'] ? $arrayParametros['strMensajeCorreo']:'';
        $strRemitente     = $arrayParametros['strRemitente'] ? $arrayParametros['strRemitente']:'';
        $strDestinatario  = $arrayParametros['strDestinatario'] ? $arrayParametros['strDestinatario']:'';
        $strRespuesta     = '';
        $objMessage = \Swift_Message::newInstance()
                                        ->setSubject($strAsunto)
                                        ->setFrom($strRemitente)
                                        ->setTo($strDestinatario)
                                        ->setBody($strMensajeCorreo, 'text/html');
        $strRespuesta = $this->get('mailer')->send($objMessage);
        return $strRespuesta;
    }
    /**
     * Documentación para la función 'subir_fichero'
     * Método encargado de subir una imagen al servidor según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 09-09-2019
     * 
     * @return array  $nombreImg
     */
    public function subirfichero($imgBase64)
    {
        $base_to_php   = explode(',', $imgBase64);
        $data          = base64_decode($base_to_php[1]);
        $ext           = explode("/",explode(";",$base_to_php[0])[0])[1];
        $pos = strpos($ext, "ico");
        if ($pos) {
            $ext = "ico";
        }
        $nombreImg     = ("bitte_".date("YmdHis").".".$ext);
        $strRutaImagen = ("images"."/".$nombreImg);
        file_put_contents($strRutaImagen,$data);
        return $nombreImg;
    }
    /**
     * Documentación para la función 'getImgBase64'
     * Método encargado de subir una imagen al servidor según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 09-09-2019
     * 
     * @return array  $data
     */
    public function getImgBase64($nameImg)
    {
        $img = file_get_contents("images/".$nameImg);
        $ext   = explode('.', $nameImg)[1];
        $data = ("data:image/".$ext.";base64," . base64_encode($img));
        return $data;
    }
}
