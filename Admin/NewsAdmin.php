<?php

namespace Example\NewsBundle\Admin;

use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Navigation\Navigation;
use Sulu\Bundle\AdminBundle\Navigation\NavigationItem;

class NewsAdmin extends Admin
{
    public function __construct($title)
    {
        $rootNavigationItem = new NavigationItem($title);

        $global = new NavigationItem('navigation.modules', $rootNavigationItem);
        $news = new NavigationItem('navigation.news', $global);
        $news->setAction('example/news');
        $news->setIcon('pencil-square-o');
        $news->setPosition(25);

        $this->setNavigation(new Navigation($rootNavigationItem));
    }

    public function getJsBundleName()
    {
        return 'examplenews';
    }
}
