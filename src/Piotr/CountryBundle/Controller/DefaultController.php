<?php

namespace Piotr\CountryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PiotrCountryBundle:Default:index.html.twig', array('name' => $name));
    }
}
