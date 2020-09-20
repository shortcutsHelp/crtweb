<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use App\Support\Config;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Interfaces\RouteCollectorInterface;
use Twig\Environment;

/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @var RouteCollectorInterface
     */
    private $routeCollector;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Config
     */
    private Config $config;

    /**
     * HomeController constructor.
     *
     * @param RouteCollectorInterface $routeCollector
     * @param Environment             $twig
     * @param EntityManagerInterface  $em
     * @param Config                  $config
     */
    public function __construct(
        RouteCollectorInterface $routeCollector,
        Environment $twig,
        EntityManagerInterface $em,
        Config $config
    ) {
        $this->routeCollector = $routeCollector;
        $this->twig = $twig;
        $this->em = $em;
        $this->config = $config;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $movies = $this->em->getRepository(Movie::class)->findAll();

        $data = $this->twig->render('home/index.html.twig', [
            'trailers' => new ArrayCollection($movies),
            'dateTime' => date_create()->format(DATE_ATOM),
            'action'   => __METHOD__,
            'baseUrl'  => $this->config->get('base_url'),
        ]);

        $response->getBody()->write($data);

        return $response;
    }

    public function show(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $movie = $this->em->getRepository(Movie::class)->find((int) $request->getAttribute('id'));

        $data = $this->twig->render('home/trailer.html.twig', [
            'trailer'  => $movie,
            'baseUrl'  => $this->config->get('base_url'),
            'dateTime' => date_create()->format(DATE_ATOM),
        ]);

        $response->getBody()->write($data);

        return $response;
    }
}
