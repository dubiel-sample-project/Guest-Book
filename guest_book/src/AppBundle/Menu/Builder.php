<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'index'));

        $em = $this->container->get('doctrine')->getManager();
        $blog = $em->getRepository('AppBundle:Entry')->findMostRecent();

        $menu->addChild('Latest Entry', array(
            'route' => 'entry_show',
            'routeParameters' => array('id' => $entry->getId())
        ));

        $menu->addChild('Entries', array('route' => 'entry'));
        $menu->addChild('Comments', array('route' => 'comment'));
        $menu->addChild('Authors', array('route' => 'author'));
		
        return $menu;
    }
}