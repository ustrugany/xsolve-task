<?php

namespace Xsolve\CrawlerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Glowny kontroler aplikacji konsumujacy feed z kanalu RSS
 */
class CrawlerController extends Controller
{
    /**
     * Url feed'a
     * @var type 
     */
    protected $rssFeedUrl = 'http://xlab.pl/feed/';
    /**
     * Dane ktore zostana przekazane do widoku
     * @var type 
     */
    protected $viewData = array();
    
    /**
     * Domyslna akcja
     */
    public function indexAction()
    {
//        $form = $this->createForm(new \Xsolve\CrawlerBundle\Form\FeedEnquiry(), array());
        /**
         * Klasa formularza odpuszczona na rzecz tworzenia formualrza
         * ad hoc 
         */
        $defaultData = array('keyword' => null);
        $form = $this->createFormBuilder($defaultData)
            ->add('keyword', 'text')
            ->getForm();
        $keyword = null;
        
        $request = $this->getRequest();
        /**
         * Tylko gdy zadanie POST 
         */
        if($request->isMethod('POST'))
        { 
            $form->bindRequest($request);
            $data = $form->getData();
            $keyword = $data['keyword'];
        }
        
        /**
         * Pobiera wpisy przekazac ew. wyszukiwana fraze
         */
        $feedData = $this->getRSSFeedData($keyword);
        $this->viewData['feed'] = $feedData;
        $this->viewData['form'] = $form->createView();
        
        return $this->render('XsolveCrawlerBundle:Crawler:index.html.twig', $this->viewData);
    }
    
    /**
     * Pobiera wpisy z kanalu 
     * przy tym filtruje pod katem podanej frazy
     * @param type $keyword
     * @return type 
     */
    protected function getRSSFeedData($keyword = null)
    {
        /**
         * Pobiera bunddle klasy do obslugi RSS
         * Simplepie 
         */
        $feed = $this->get('fkr_simple_pie.rss');
        
        /**
         * Pobranie zawartosci kanalu 
         */
        $feed->set_feed_url($this->rssFeedUrl);
        $feed->set_output_encoding('UTF-8');
        $feed->set_input_encoding('UTF-8');
        $feed->enable_cache(true);
        $feed->strip_htmltags();
        $feed->init();
        $feed->handle_content_type();
        
        
        $items = $feed->get_items();
        
        /**
         * Filtrowanie
         */
        $items = $this->filterFeedItemsByKeyword($items, $keyword);
       
        /**
         * Dane do widoku 
         */
        $feedData = array(
                'permalink' => $feed->get_permalink(),
                'title' => $feed->get_title(),
                'description' => $feed->get_description(),
                'items' => $items
        );
        return $feedData;
    }
    
    /**
     * Filtruje wpisy pod katem slowa kluczowego w description
     * @param type $items
     * @param type $keyword
     * @return type 
     */
    protected function filterFeedItemsByKeyword($items, $keyword)
    {
        $result = array();
        
        if(is_array($items))
        {
            /**
             * Czy dozwolone slowo 
             */
            $keyword = $this->checkKeywordValid($keyword);
            if(!is_null($keyword))
            {
                $this->viewData['keyword'] = $keyword;
                
                foreach($items as $item)
                {
                    $pattern = "/{$keyword}/iu";
                    
                    /**
                     * Wpisy pobierane przez simplepie maja zakodowane polskie
                     * znaki, trzeba przepuscic przed przeszukaniem przez 
                     * html_entity_decode 
                     */
                    $description = html_entity_decode($item->get_description(), null, "UTF-8");
                    
                    /**
                     * Filtrowanie przy uzyciu wyrazen regularnych 
                     */
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
    
    /**
     * Waliduje wyszukiwane slowo
     * @param type $keyword
     * @return boolean 
     */
    protected function checkKeywordValid($keyword)
    {
        $result = null;
        if(is_string($keyword))
        {
            $keyword = trim($keyword);
            $pattern = '/^[a-z0-9_\-.:!?;ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]*$/is';
            if(preg_match($pattern, $keyword))
            {
                $result = $keyword;
            }
        }
        return $result;
    }
}
