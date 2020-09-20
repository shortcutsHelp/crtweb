<?php


namespace App\Service\RSS\Entity\Movie;


/**
 * Class Item
 *
 * @package App\Service\RSS\Entit\Movie
 */
class Item
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
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $pubDate;
    /**
     * @var string
     */
    private string $content;

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
     * @return Item
     */
    public function setTitle(string $title): Item
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
     * @return Item
     */
    public function setLink(string $link): Item
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
     * @return Item
     */
    public function setDescription(string $description): Item
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getPubDate(): \DateTimeInterface
    {
        return $this->pubDate;
    }

    /**
     * @param \DateTimeInterface $pubDate
     *
     * @return Item
     */
    public function setPubDate(\DateTimeInterface $pubDate): Item
    {
        $this->pubDate = $pubDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return Item
     */
    public function setContent(string $content): Item
    {
        $this->content = $content;
        return $this;
    }
}