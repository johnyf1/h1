<?php
// src/AppBundle/Menu/Builder.php
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

        $menu->addChild('Company', array('route' => 'homepage'));
        $menu->addChild('Operators', array('route' => 'operators'));
        $menu->addChild('Firefighters', array('route' => 'firefighters'));
        $menu->addChild('Alarms', array('route' => 'alarms'));
        $menu->addChild('Logs', array('route' => 'logs'));
        $menu->addChild('Users - users are not implemented yet', array('route' => 'homepage'));        

        return $menu;
    }
}