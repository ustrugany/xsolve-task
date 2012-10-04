<?php
namespace Xsolve\CrawlerBundle\Form;
    
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FeedEnquiry extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('keyword');
    }

    public function getName()
    {
        return 'feed_enquiry';
    }
}