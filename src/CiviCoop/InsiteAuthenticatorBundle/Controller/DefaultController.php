<?php

namespace CiviCoop\InsiteAuthenticatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CiviCoopInsiteAuthenticatorBundle:Default:index.html.twig', array('name' => $name));
    }
}
