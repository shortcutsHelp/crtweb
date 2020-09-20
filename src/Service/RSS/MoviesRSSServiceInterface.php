<?php


namespace App\Service\RSS;


use Psr\Http\Message\ResponseInterface;

interface MoviesRSSServiceInterface
{
    public function fetchMovies(): ResponseInterface;
    public function setSource(string $source = null): self;
    public function getSource(): string;
}