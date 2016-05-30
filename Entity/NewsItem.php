<?php

namespace Example\NewsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;
use Sulu\Bundle\MediaBundle\Entity\Media;

/**
 * @ExclusionPolicy("all")
 */
class NewsItem
{
    /**
     * @var integer
     *
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @Expose
     */
    private $title;

    /**
     * @var string
     *
     * @Expose
     */
    private $content;

    /**
     * @var string
     */
    private $mediaDisplayOption;

    /**
     * @var Collection
     */
    private $medias;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return NewsItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return NewsItem
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set mediaDisplayOption
     *
     * @param string $mediaDisplayOption
     *
     * @return NewsItem
     */
    public function setMediaDisplayOption($mediaDisplayOption)
    {
        $this->mediaDisplayOption = $mediaDisplayOption;

        return $this;
    }

    /**
     * Get mediaDisplayOption
     *
     * @return string
     */
    public function getMediaDisplayOption()
    {
        return $this->mediaDisplayOption;
    }

    /**
     * Add media
     *
     * @param Media $media
     *
     * @return NewsItem
     */
    public function addMedia(Media $media)
    {
        $this->medias[] = $media;

        return $this;
    }

    /**
     * Remove media
     *
     * @param Media $media
     */
    public function removeMedia(Media $media)
    {
        $this->medias->removeElement($media);
    }

    /**
     * Get medias
     *
     * @return Collection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * Set medias
     *
     * @param array $medias
     */
    public function setMedias(array $medias)
    {
        $this->medias = new ArrayCollection($medias);
    }

    /**
     * Returns media property formatted to be used in the UI.
     *
     * @VirtualProperty
     */
    public function getMedia()
    {
        return [
            'displayOption' => $this->getMediaDisplayOption(),
            'ids' => $this->getMedias()->map(
                function (Media $media) {
                    return $media->getId();
                }
            ),
        ];
    }
}
