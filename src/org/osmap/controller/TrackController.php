<?php
namespace org\osmap\controller;

use org\osmap\db\model\Track;
use org\osmap\db\repository\TrackRepository;
use org\osmap\utils\gpx\Bounds;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TrackController
{

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

    public function getTracksForBounds(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $bounds = Bounds::getBountsFromQuery($request);
        $tracks = $this->trackRepository->getByBounds($bounds);
        $response->getBody()->write(json_encode($tracks));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getTracksByUserid(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $userid = $args['userid'];
        $tracks = $this->trackRepository->getByUserid($userid);
        $response->getBody()->write(json_encode($tracks));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function addTrack(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $data = $request->getParsedBody();
            $gpx = $data['gpx'] ?? null;
            $bounds = $data['bounds'] ?? null;  
            $title = $data["title"] ?? null;
            $userid = $data["userid"] ?? null;
            $boundsArr = explode(";", $bounds);           

            $track = Track::Create($title, $userid, $gpx, $boundsArr[0], $boundsArr[1], $boundsArr[2], $boundsArr[3]);
            $newId = $this->trackRepository->addTrack($track);
            $json = '{"id": "' . $newId . '"}';
            $response->getBody()->write(json_encode($json));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $e) {

            $error = [
                'error' => true,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => $data
            ];

            $response->getBody()->write(json_encode($error));
            return $response
                ->withStatus(500)
                ->withHeader('Content-Type', 'application/json');
        }
    }
}