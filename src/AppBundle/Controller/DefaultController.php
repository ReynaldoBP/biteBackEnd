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
}
