<?php

namespace Example\NewsBundle\Controller;

use Example\NewsBundle\News\NewsManager;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineFieldDescriptor;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends FOSRestController
{
    const ENTITY_NAME = 'ExampleNewsBundle:NewsItem';

    /**
     * Returns array of existing field-descriptors.
     *
     * @return array
     */
    private function getFieldDescriptors()
    {
        return [
            'id' => new DoctrineFieldDescriptor(
                'id',
                'id',
                self::ENTITY_NAME,
                'public.id',
                [],
                true
            ),
            'title' => new DoctrineFieldDescriptor(
                'title',
                'title',
                self::ENTITY_NAME,
                'public.title'
            ),
            'content' => new DoctrineFieldDescriptor(
                'content',
                'content',
                self::ENTITY_NAME,
                'news.content'
            ),
            'releaseDate' => new DoctrineFieldDescriptor(
                'releaseDate',
                'releaseDate',
                self::ENTITY_NAME,
                'news.release-date'
            )
        ];
    }

    /**
     * Returns all fields that can be used by list.
     *
     * @FOS\RestBundle\Controller\Annotations\Get("news/fields")
     *
     * @return Response
     */
    public function getNewsFieldsAction()
    {
        return $this->handleView($this->view(array_values($this->getFieldDescriptors())));
    }

    /**
     * Shows all news-items
     *
     * @param Request $request
     *
     * @Get("news")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNewsListAction(Request $request)
    {
        $restHelper = $this->get('sulu_core.doctrine_rest_helper');
        $factory = $this->get('sulu_core.doctrine_list_builder_factory');

        $fieldDescriptors = $this->getFieldDescriptors();
        $listBuilder = $factory->create(self::ENTITY_NAME);
        $restHelper->initializeListBuilder($listBuilder,$fieldDescriptors);

        if (null === $request->get('sortBy')) {
            // default sort-by releaseDate ASC
            $listBuilder->sort($fieldDescriptors['releaseDate']);
        }

        $results = $listBuilder->execute();

        $list = new ListRepresentation(
            $results,
            'news-items',
            'get_news_list',
            $request->query->all(),
            $listBuilder->getCurrentPage(),
            $listBuilder->getLimit(),
            $listBuilder->count()
        );

        $view = $this->view($list, 200);

        return $this->handleView($view);
    }

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
