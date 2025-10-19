<?php
namespace Org\Osmap\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PDO; 

class TrackController{

    private PDO $pdo;

    function __construct(PDO $pdo) 
    { 
        $this->pdo = $pdo;         
    }

    public function getTracks(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getQueryParams();
        $stmt = $this->pdo->query("SELECT * FROM track");
        $tracks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode($tracks));
        return $response->withHeader('Content-Type', 'application/json');
    }
}