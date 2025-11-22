<?php
namespace org\osmap\controller;

use org\osmap\db\model\Track;
use org\osmap\dto\TrackDto;
use org\osmap\db\repository\TrackRepository;
use org\osmap\utils\gpx\Bounds;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

class TrackController
{

    private TrackRepository $trackRepository;
    private string $appHost;

    function __construct(TrackRepository $trackRepository, ContainerInterface $containerInterface)
    {
        $this->trackRepository = $trackRepository;
        $this->appHost = $this->GetHost($containerInterface);
    }

    private function GetHost(ContainerInterface $containerInterface) : string {
        $settings = $containerInterface->get('settings');
        return $settings["app"]["host"];
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
    public function getTracksListByUserid(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $userid = $args['userid'];
        $tracks = $this->trackRepository->getByTrackListUserid($userid);
        $result = array_map (function($t)use ($userid): TrackDto {
            $dto = new TrackDto();
            $dto->name = $t->title;
            $dto->gpx = "$this->appHost/api/track/$userid/$t->id ";
            return $dto;
        }, $tracks);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function getTrackByUserid(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $userid = $args['userid'];
        $trackId = $args['trackId'];
        $gpx = $this->trackRepository->getTrackByUserid($trackId, $userid);
        $response->getBody()->write(simplexml_load_string($gpx)->asXML());
        return $response->withHeader('Content-Type', 'application/xml');
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