<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('strireplace', array($this, 'strireplaceFilter'))
        );
    }

    public function strireplaceFilter($subject, $search, $replace)
    {
        return str_ireplace($search, $replace, $subject);
    }

    public function getName()
    {
        return 'app_extension';
    }
}