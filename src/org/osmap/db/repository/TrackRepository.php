<?php
namespace Org\Osmap\Db\Repository;
use Org\Osmap\Db\Model\Track;
use Org\Osmap\Utils\Gpx\Bounds;
use PDO;

class TrackRepository{
    private PDO $pdo;
    function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

     public function getAll(): array {
        $sql = "SELECT * FROM track";

        $stmt = $this->pdo->query($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Track::class);
        return $stmt->fetchAll(); 
    }

    public function getByBounds(Bounds $bounds): array {
        $sql = "SELECT * FROM track WHERE NOT (
                max_lng < :minLng OR
                min_lng > :maxLng OR
                max_lat < :minLat OR
                min_lat > :maxLat)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'minLng' => $bounds->minLng,
            'maxLng' => $bounds->maxLng,
            'minLat' => $bounds->minLat, 
            'maxLat' => $bounds->maxLat, 
        ]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Track::class);
        return $stmt->fetchAll();
    }
}