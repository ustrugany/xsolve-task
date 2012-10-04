<?php

namespace Xsolve\CrawlerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CrawlerController extends Controller
{
    public function indexAction($name = null)
    {
        
        echo (int)$this->isKeywordValid('asdsad ąśą 23');exit;
        $feed = $this->get('fkr_simple_pie.rss');
        $feed->set_feed_url('http://xlab.pl/feed/');
        $feed->set_output_encoding('UTF-8');
        $feed->set_input_encoding('UTF-8');
        $feed->strip_htmltags();
        $feed->init();
        $feed->handle_content_type();
        return $this->render('XsolveCrawlerBundle:Crawler:index.html.twig', array('feed' => $feed));
    }
    
    protected function filterOutByDescription($items, $keyword)
    {
        $result = null;
        if(is_array($items))
        {
            $pattern = "";
            $result = array();
            foreach($items as $item)
            {
                
            }
        }
        return $result;
    }
    
    protected function isKeywordValid($keyword)
    {
        $result = false;
        $pattern = '/^[a-z0-9_\-.:!?;ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]*$/is';
        if(preg_match($pattern, $keyword))
        {
            $result = true;
        }
        return $result;
    }
    
    public function searchAction()
    {
        return $this->render('XsolveCrawlerBundle:Crawler:search.html.twig', array('form' => ''));
    }
}
