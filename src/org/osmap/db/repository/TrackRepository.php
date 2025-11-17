<?php
namespace org\osmap\db\repository;
use org\osmap\db\model\Track;
use org\osmap\utils\gpx\Bounds;
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

    public function getByUserid($userid): array {
        $sql = "SELECT * FROM track WHERE userid = :userid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'userid' => $userid,           
        ]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Track::class);
        return $stmt->fetchAll();
    }

    public function addTrack(Track $track): string {
        $sql = "INSERT INTO track(title, gpx, userid, max_lng, min_lng, max_lat, min_lat) 
        VALUES(:title, :gpx, :userid, :max_lng, :min_lng, :max_lat, :min_lat)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'title' => $track->title,
            'gpx' => $track->gpx,
            'userid' => $track->userid,
            'max_lng' => $track->max_lng, 
            'min_lng' => $track->min_lng, 
            'max_lat' => $track->max_lat, 
            'min_lat' => $track->min_lat, 
        ]);
        return $this->pdo->lastInsertId();    }
}