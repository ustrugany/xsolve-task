<?php

namespace Xsolve\CrawlerBundle\Twig\Extension;

class XsolveExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'htmldecode' => new \Twig_Filter_Method($this, 'htmldecode', array(
                'is_safe' => array('html'))
            ),
            'wrapsearch' => new \Twig_Filter_Method($this, 'wrapsearch', array(
                'is_safe' => array('html'))
            ),
        );
    }

    public function htmldecode($string)
    {
        return html_entity_decode($string);
    }

    public function wrapsearch($string, $search = "XSolve")
    {
        $pattern = "/{$search}/i";
        $string = preg_replace($pattern, "<span class=\"search-found\">{$search}</span>", $string);
        return $string;
    }

    public function getName()
    {
        return 'html_xsolve_twig_extension';
    }

}
