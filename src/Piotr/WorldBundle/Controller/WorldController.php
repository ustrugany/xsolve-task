<?php

namespace Piotr\WorldBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class WorldController extends Controller
{
    public function indexAction($name)
    {
        return new Response($name);
//        return $this->render('PiotrWorldBundle:World:index.html.twig', array('name' => $name));
    }
}
