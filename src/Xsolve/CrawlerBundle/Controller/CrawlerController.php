<?php

namespace Xsolve\CrawlerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CrawlerController extends Controller
{
    protected $rssFeedUrl = 'http://xlab.pl/feed/';
    protected $viewData = array();
    
    public function indexAction()
    {
        $keyword = $this->getRequest()->get('keyword', null);
        $feedData = $this->getRSSFeedData($keyword);
        
        $this->viewData['feed'] = $feedData;
        return $this->render('XsolveCrawlerBundle:Crawler:index.html.twig', $this->viewData);
    }
    
    protected function getRSSFeedData($keyword = null)
    {
        $feed = $this->get('fkr_simple_pie.rss');
        $feed->set_feed_url($this->rssFeedUrl);
        $feed->set_output_encoding('UTF-8');
        $feed->set_input_encoding('UTF-8');
        $feed->enable_cache(true);
        $feed->strip_htmltags();
        $feed->init();
        $feed->handle_content_type();
        
        
        $items = $feed->get_items();
        $items = $this->filterFeedItemsByKeyword($items, $keyword);
       
        $feedData = array(
                'permalink' => $feed->get_permalink(),
                'title' => $feed->get_title(),
                'description' => $feed->get_description(),
                'items' => $items
        );
        return $feedData;
    }
    
    protected function filterFeedItemsByKeyword($items, $keyword)
    {
        $result = array();
        
        if(is_array($items))
        {
            if($this->isKeywordValid($keyword))
            {

                $this->viewData['keyword'] = $keyword;
                $this->viewData['keywordReplacement'] = $this->keywordFoundReplacement($keyword);
                
                foreach($items as $item)
                {

                    $pattern = "/\b{$keyword}\b/i";
                    $description = html_entity_decode($item->get_description());

                    if(preg_match($pattern, $description))
                    {
                        $result[] = $item;
                    }
                }
            }
            else
            {
                $result = $items;
            }
        }
        
        return $result;
    }
    
    protected function keywordFoundReplacement($keyword)
    {
        return "<span class=\"search-found\">{$keyword}</span>";
    }
    
    protected function isKeywordValid($keyword)
    {
        $result = false;
        if(is_string($keyword))
        {
            $pattern = '/^[a-z0-9_\-.:!?;ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]*$/is';
            if(preg_match($pattern, $keyword))
            {
                $result = true;
            }
        }
        return $result;
    }
}
