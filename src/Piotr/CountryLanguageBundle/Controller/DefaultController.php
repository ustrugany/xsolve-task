<?php

namespace Piotr\CountryLanguageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PiotrCountryLanguageBundle:Default:index.html.twig', array('name' => $name));
    }
}
