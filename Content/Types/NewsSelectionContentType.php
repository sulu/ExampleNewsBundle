<?php

namespace Example\NewsBundle\Content\Types;

use Example\NewsBundle\News\NewsManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\SimpleContentType;

/**
 * ContentType for News.
 */
class NewsSelectionContentType extends SimpleContentType
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var NewsManager
     */
    private $newsManager;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct($template, NewsManager $newsManager, SerializerInterface $serializer)
    {
        parent::__construct('News', []);

        $this->template = $template;
        $this->newsManager = $newsManager;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentData(PropertyInterface $property)
    {
        $value = $property->getValue();

        if ($value === null || !is_array($value) || count($value) === 0) {
            return [];
        }

        $entities = $this->newsManager->readList($value);

        $result = [];
        foreach ($entities as $entity) {
            $result[array_search($entity->getId(), $value, false)] = $this->serializer->serialize(
                $entity,
                'array',
                SerializationContext::create()->setSerializeNull(true)
            );
        }

        ksort($result);

        return array_values($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
