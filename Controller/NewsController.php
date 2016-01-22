<?php

namespace Example\NewsBundle\Controller;

use Example\NewsBundle\News\NewsManager;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends FOSRestController
{
    /**
     * Returns a single news-item identified by id.
     *
     * @param int $id
     *
     * @return Response
     */
    public function getNewsAction($id)
    {
        $newsItem = $this->getManager()->read($id);

        return $this->handleView($this->view($newsItem));
    }

    /**
     * Returns all news-items.
     *
     * @Get("news")
     *
     * @return Response
     */
    public function getNewsListAction()
    {
        $newsItems = $this->getManager()->readAll();

        return $this->handleView($this->view($newsItems));
    }

    /**
     * Create a new news-item and returns it.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postNewsAction(Request $request)
    {
        $newsItem = $this->getManager()->create($request->request->all());
        $this->flush();

        return $this->handleView($this->view($newsItem));
    }

    /**
     * Update a news-item with given id and returns it.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function putNewsAction($id, Request $request)
    {
        $newsItem = $this->getManager()->update($id, $request->request->all());
        $this->flush();

        return $this->handleView($this->view($newsItem));
    }

    /**
     * Delete news-item.
     *
     * @param int $id
     *
     * @return Response
     */
    public function deleteNewsAction($id)
    {
        $this->getManager()->delete($id);
        $this->flush();

        return $this->handleView($this->view());
    }

    /**
     * Returns service for news-items.
     *
     * @return NewsManager
     */
    private function getManager()
    {
        return $this->get('example_news.manager');
    }

    /**
     * Flushes database.
     */
    private function flush()
    {
        $this->get('doctrine.orm.entity_manager')->flush();
    }
}
