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
   * @Rest\Post("/crearUsuario/")
   * @param Request $request
   * @return Json
   */
   public function postAction(Request $request)
   {
       $name = $request->get('name');
       $role = $request->get('role');
       if(empty($name) || empty($role))
       {
          return array("respuesta" => 'Nombre'.$name);
       }
       return array('respuesta' => 'SI');
    }
}

