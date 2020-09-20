<?php


namespace App\Service\RSS;


use App\Service\RSS\Entity\Movie\RssChannel;

interface MoviesRSSConverterInterface
{
    public function convertToRssChannelWithItems(string $xml): RssChannel;
}