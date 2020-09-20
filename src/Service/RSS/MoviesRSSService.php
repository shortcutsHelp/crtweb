<?php


namespace App\Service\RSS;


use App\Support\Config;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Console\Exception\RuntimeException;

/**
 * Class MoviesRSSService
 *
 * @package App\Service\RSS
 */
class MoviesRSSService implements MoviesRSSServiceInterface
{
    /**
     * @var Config
     */
    private Config $config;
    /**
     * @var ClientInterface
     */
    private ClientInterface $httpClient;
    /**
     * @var string
     */
    private ?string $source;

    /**
     * MoviesRSSService constructor.
     *
     * @param ClientInterface $httpClient
     * @param Config          $config
     */
    public function __construct(
        ClientInterface $httpClient,
        Config $config
    ) {
        $this->config = $config;
        $this->httpClient = $httpClient;
    }

    /**
     * @return ResponseInterface
     */
    public function fetchMovies(): ResponseInterface
    {
        return $this->fetch($this->getSource());
    }

    /**
     * @param string $source
     *
     * @return ResponseInterface
     */
    private function fetch(string $source): ResponseInterface
    {
        try {
            $response = $this->httpClient->sendRequest(new Request('GET', $source));
        } catch (ClientExceptionInterface $e) {
            throw new RuntimeException($e->getMessage());
        }

        if (($status = $response->getStatusCode()) !== 200) {
            throw new RuntimeException(sprintf('Response status is %d, expected %d', $status, 200));
        }

        return $response;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        if ($this->source) {
            return $this->source;
        }

        if (!isset($this->config->get('rss')['source'])) {
            throw new RuntimeException('Undefined RSS Source');
        }

        return $this->config->get('rss')['source'];
    }

    /**
     * @param string|null $source
     *
     * @return $this
     */
    public function setSource(string $source = null): self
    {
        $this->source = $source;
        return $this;
    }
}