<?php

namespace Xsolve\CrawlerBundle\Twig\Extension;

/**
 * Rozszerzenie dla dodatkowych funkcjonalnosci Twiga
 */
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

    /**
     * Dekoduje feedy serwowane przez simplepie
     */
    public function htmldecode($string)
    {
		//var_dump('konwersja:' . mb_convert_encoding($string, 'ISO-8859-2', 'UTF-8'));
        return html_entity_decode($string, null, "UTF-8");
    }

    /**
     * Opakowuje poszukiwana fraze
     */
    public function wrapsearch($string, $search)
    {
        $pattern = "/{$search}/iu";
        $string = preg_replace($pattern, "<span class=\"search-found\">$0</span>", $string);
        return $string;
    }

    public function getName()
    {
        return 'html_xsolve_twig_extension';
    }

}
