<?php

namespace Xsolve\CrawlerBundle\Twig\Extension;

class DecodeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'htmldecode' => new \Twig_Filter_Method($this, 'htmldecode', array(
                'is_safe' => array('html'))
            ),
        );
    }

    public function htmldecode($string)
    {
        return html_entity_decode($string);
    }

    public function getName()
    {
        return 'html_decode_twig_extension';
    }

}
