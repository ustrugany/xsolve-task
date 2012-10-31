<?php

namespace Piotr\WorldBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PiotrWorldBundle extends Bundle
{
    
    public function indexAction($name)
    {    
        return $name;
    }
}
