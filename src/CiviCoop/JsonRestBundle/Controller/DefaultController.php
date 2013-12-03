<?php

namespace CiviCoop\JsonRestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CiviCoopJsonRestBundle:Default:index.html.twig', array('name' => $name));
    }
}
