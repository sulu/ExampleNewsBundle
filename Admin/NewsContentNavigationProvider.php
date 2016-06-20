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

        return [$details];
    }
}
