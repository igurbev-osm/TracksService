<?php
namespace Org\Osmap\Controller;

use Org\Osmap\Db\Repository\TrackRepository;
use Org\Osmap\Utils\Gpx\Bounds;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TrackController{

    private TrackRepository $trackRepository;

    function __construct(TrackRepository $trackRepository) 
    { 
        $this->trackRepository = $trackRepository;         
    }

    public function getTracks(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $tracks = $this->trackRepository->getAll();

        $response->getBody()->write(json_encode($tracks));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getTracksForBounds(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface{

        $bounds = Bounds::getBountsFromQuery($request);
        $tracks = $this->trackRepository->getByBounds($bounds);
        $response->getBody()->write(json_encode($tracks));
        return $response->withHeader('Content-Type', 'application/json');
    }

    
}