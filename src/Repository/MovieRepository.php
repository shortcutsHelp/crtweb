<?php
/**
 * 2019-06-28.
 */

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Movie;
use App\Service\RSS\Entity\Movie\Item;
use App\Service\RSS\Entity\Movie\RssChannel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * Class MovieRepository.
 */
class MovieRepository extends EntityRepository
{
    public function reloadLastNewMovies(RssChannel $rssChannel, int $count)
    {
        $items = new ArrayCollection($rssChannel->getItems()->slice(0, $count));
        $titles = $items->map(function (Item $item) {
            return $item->getTitle();
        });

        if (!$titles->count()) {
            return;
        }

        $titleMovie = [];

        $existingMovies = new ArrayCollection($this->getMoviesByTitles($titles->toArray()));

        foreach ($existingMovies as $existingMovie) {
            $titleMovie[$existingMovie->getTitle()] = $existingMovie;
        }

        foreach ($items as $item) {
            /**
             * @var Item $item
             */
            if (isset($titleMovie[$item->getTitle()])) {
                $movie = $titleMovie[$item->getTitle()];
            } else {
                $movie = new Movie();
            }

            $trailer = $movie
                ->setTitle($item->getTitle())
                ->setDescription($item->getDescription())
                ->setLink($item->getLink())
                ->setImage($item->getImage())
                ->setPubDate($item->getPubDate());

            $this->_em->persist($trailer);
        }

        $this->_em->flush();
    }

    public function getMoviesByTitles(array $titles)
    {
        return $this->createQueryBuilder('movies')
            ->where('movies.title IN (:titles)')
            ->setParameter('titles', $titles)
            ->getQuery()
            ->getResult();
    }
}
