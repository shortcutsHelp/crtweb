<?php
/**
 * 2019-06-28.
 */

declare(strict_types=1);

namespace App\Command;

use App\Entity\Movie;
use App\Service\RSS\MoviesRSSConverterInterface;
use App\Service\RSS\MoviesRSSServiceInterface;
use App\Support\Config;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

/**
 * Class FetchDataCommand.
 */
class FetchDataCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'fetch:trailers';

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * @var MoviesRSSServiceInterface
     */
    private MoviesRSSServiceInterface $moviesRSSService;
    /**
     * @var MoviesRSSConverterInterface
     */
    private MoviesRSSConverterInterface $moviesRSSConverter;

    /**
     * FetchDataCommand constructor.
     *
     * @param ClientInterface             $httpClient
     * @param LoggerInterface             $logger
     * @param EntityManagerInterface      $em
     * @param MoviesRSSServiceInterface   $moviesRSSService
     * @param MoviesRSSConverterInterface $moviesRSSConverter
     * @param string|null                 $name
     */
    public function __construct(
        ClientInterface $httpClient,
        LoggerInterface $logger,
        EntityManagerInterface $em,
        MoviesRSSServiceInterface $moviesRSSService,
        MoviesRSSConverterInterface $moviesRSSConverter,
        string $name = null
    ) {
        parent::__construct($name);
        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->doctrine = $em;
        $this->moviesRSSService = $moviesRSSService;
        $this->moviesRSSConverter = $moviesRSSConverter;
    }

    public function configure(): void
    {
        $this->setDescription('Fetch data from iTunes Movie Trailers')
            ->addArgument('source', InputArgument::OPTIONAL, 'Overwrite source');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \Exception
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = 10;

        $this->moviesRSSService->setSource($input->getArgument('source'));

        $this->logger->info(sprintf('Start %s at %s', __CLASS__, (string) date_create()->format(DATE_ATOM)));

        $io = new SymfonyStyle($input, $output);
        $io->title(sprintf('Fetch data from %s', $this->moviesRSSService->getSource()));

        $xml = $this->moviesRSSService->fetchMovies()->getBody()->getContents();
        $rssChannel = $this->moviesRSSConverter->convertToRssChannelWithItems($xml);

        $this->doctrine->getRepository(Movie::class)->reloadLastNewMovies($rssChannel, $count);

        $this->logger->info(sprintf('End %s at %s', __CLASS__, (string) date_create()->format(DATE_ATOM)));

        return 0;
    }
}
