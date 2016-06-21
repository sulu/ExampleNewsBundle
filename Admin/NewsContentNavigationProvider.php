<?php

namespace Example\NewsBundle\Admin;

use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationItem;
use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationProviderInterface;

class NewsContentNavigationProvider implements ContentNavigationProviderInterface
{
    public function getNavigationItems(array $options = [])
    {
        $details = new ContentNavigationItem('content-navigation.example.details');
        $details->setAction('details');
        $details->setPosition(10);
        $details->setComponent('news/edit/details@examplenews');

        $seo = new ContentNavigationItem('content-navigation.example.seo');
        $seo->setAction('seo');
        $seo->setPosition(20);
        $seo->setComponent('news/edit/seo@examplenews');

        return [$details, $seo];
    }
}
