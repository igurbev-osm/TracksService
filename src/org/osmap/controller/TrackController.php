<?php
namespace org\osmap\controller;

use org\osmap\db\model\Track;
use org\osmap\db\repository\TrackRepository;
use org\osmap\utils\gpx\Bounds;
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

    public function addTrack(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface{
        $data = $request->getParsedBody();
        $gpx = $data['pgx'] ?? null;
        $bounds = $data['bounds'] ?? null;
        $title = $data["title"] ?? null;
        $boundsArr = explode(";", $bounds);

        $track = new Track(null, $title, 1, $gpx, $boundsArr[0],$boundsArr[1],$boundsArr[2],$boundsArr[3]);
        $newId = $this->trackRepository->addTrack($track);
        $json = '{"id": "' + $newId + '"}';
        $response->getBody()->write(json_encode($json));
        return $response->withHeader('Content-Type', 'application/json');
    }
}