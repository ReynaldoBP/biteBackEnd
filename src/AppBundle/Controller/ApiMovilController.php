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
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class ApiMovilController extends FOSRestController
{

  /**
   * @Rest\Post("/movilBitte/procesar")
   * @param Request $request
   * @return Json
   */
   public function postAction(Request $request)
   {
       $operacion    = $request->get('op');
       $arrayRequest = json_decode($request->getContent(),true);
       $arrayData    = $arrayRequest['data'];
       if($operacion)
       {
           switch($operacion)
	   {
	       case 'putIngresarCliente':
	           $arrayRespuesta = 
$this->putIngresarCliente($arrayData);
break;
	   }
       }
       return $arrayRespuesta;
    }

    private function putIngresarCliente($arrayData)
    {
       $name = $arrayData['nombre'];
       $role = $arrayData['correo'];
       return array('nombres' => $name);
    }  
    
}

