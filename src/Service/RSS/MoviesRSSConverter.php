<?php


namespace App\Service\RSS;


use App\Service\RSS\Entity\Movie\Item;
use App\Service\RSS\Entity\Movie\RssChannel;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Exception\RuntimeException;

class MoviesRSSConverter implements MoviesRSSConverterInterface
{
    public function convertToRssChannelWithItems(string $xml): RssChannel
    {
        $xmlObject = (new \SimpleXMLElement($xml))->children();

        if (!property_exists($xmlObject, 'channel')) {
            throw new RuntimeException('Could not find \'channel\' element in feed');
        }

        $rssChannel = $this->buildRssChannel($xmlObject);

        $items = $this->buildItems($xmlObject);

        return $rssChannel->setItems($items);
    }

    private function buildRssChannel(\SimpleXMLElement $xmlObject)
    {
        return (new RssChannel())
            ->setCopyright($xmlObject->channel->copyright)
            ->setDescription($xmlObject->channel->description)
            ->setGenerator($xmlObject->channel->generator)
            ->setLanguage($xmlObject->channel->language)
            ->setLastBuildDate(new DateTime($xmlObject->channel->lastBuildDate))
            ->setCopyright($xmlObject->channel->copyright);
    }

    private function buildItems(\SimpleXMLElement $xmlObject): ArrayCollection
    {
        $items = [];

        foreach ($xmlObject->channel->item as $item) {
            $items[] = $this->buildItem($item);
        }

        return new ArrayCollection($items);
    }

    private function buildItem(\SimpleXMLElement $item): Item
    {
        return (new Item())
            ->setDescription($item->description)
            ->setContent($item->content)
            ->setLink($item->link)
            ->setPubDate(new DateTime($item->pubDate))
            ->setTitle($item->title);
    }
}