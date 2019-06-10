<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Renderer\RendererInterface;


class Builder{

    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function mainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');

        $menu->setChildrenAttribute('class', 'navbar-nav mr-auto');


        $menu->addChild('Главная', ['route' => 'index_index'])
            ->setAttributes([
                'class' => 'nav-item'
            ]);

        return $menu;

    }
}