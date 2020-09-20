<?php


namespace App\Service\RSS\Entity\Movie;


use Doctrine\Common\Collections\ArrayCollection;

class RssChannel
{
    /**
     * @var string
     */
    private string $title;
    /**
     * @var string
     */
    private string $link;
    /**
     * @var string
     */
    private string $description;
    /**
     * @var string
     */
    private string $language;
    /**
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $lastBuildDate;
    /**
     * @var string
     */
    private string $generator;
    /**
     * @var string
     */
    private string $copyright;
    /**
     * @var ArrayCollection
     */
    private ArrayCollection $items;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return RssChannel
     */
    public function setTitle(string $title): RssChannel
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return RssChannel
     */
    public function setLink(string $link): RssChannel
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return RssChannel
     */
    public function setDescription(string $description): RssChannel
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return RssChannel
     */
    public function setLanguage(string $language): RssChannel
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getLastBuildDate(): \DateTimeInterface
    {
        return $this->lastBuildDate;
    }

    /**
     * @param \DateTimeInterface $lastBuildDate
     *
     * @return RssChannel
     */
    public function setLastBuildDate(\DateTimeInterface $lastBuildDate): RssChannel
    {
        $this->lastBuildDate = $lastBuildDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getGenerator(): string
    {
        return $this->generator;
    }

    /**
     * @param string $generator
     *
     * @return RssChannel
     */
    public function setGenerator(string $generator): RssChannel
    {
        $this->generator = $generator;
        return $this;
    }

    /**
     * @return string
     */
    public function getCopyright(): string
    {
        return $this->copyright;
    }

    /**
     * @param string $copyright
     *
     * @return RssChannel
     */
    public function setCopyright(string $copyright): RssChannel
    {
        $this->copyright = $copyright;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems(): ArrayCollection
    {
        return $this->items;
    }

    /**
     * @param ArrayCollection $items
     *
     * @return RssChannel
     */
    public function setItems(ArrayCollection $items): RssChannel
    {
        $this->items = $items;
        return $this;
    }


}