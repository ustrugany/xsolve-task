<?php
// src/Blogger/BlogBundle/Form/EnquiryType.php
namespace Xsolve\CrawlerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FeedEnquiry extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('keyword');
    }

    public function getName()
    {
        return 'feed-enquiry';
    }
}