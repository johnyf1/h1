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
        $menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'side_text_nav',
                'id'                => 'icon_nav_v',
            ),
        ));
        $menu->addChild('<span class="icon-dashboard"></span>Customer', array(
            'route' => 'homepage',
            'class' => 'js-sub-menu-toggle',
            'extras' => array(
                'safe_label' => true
            ),
        ));

        $menu->addChild('<span class="icon-dashboard"></span>Operators', array(
            'route' => 'operators',
            'class' => 'js-sub-menu-toggle',
            'extras' => array(
                'safe_label' => true
            ),
        ));

        $menu->addChild('<span class="icon-dashboard"></span>Firefighters', array(
            'route' => 'firefighters',
            'class' => 'js-sub-menu-toggle',
            'extras' => array(
                'safe_label' => true
            ),
        ));

        $menu->addChild('<span class="icon-dashboard"></span>Alarms', array(
            'route' => 'alarms',
            'class' => 'js-sub-menu-toggle',
            'extras' => array(
                'safe_label' => true
            ),
        ));

        $menu->addChild('<span class="icon-dashboard"></span>Logs', array(
            'route' => 'logs',
            'class' => 'js-sub-menu-toggle',
            'extras' => array(
                'safe_label' => true
            ),
        ));

        $menu->addChild('<span class="icon-dashboard"></span>Users', array(
            'route' => 'users',
            'class' => 'js-sub-menu-toggle',
            'extras' => array(
                'safe_label' => true
            ),
        ));


        return $menu;
    }
}