<?php
$host = '10.8.0.1';
$port = '5432';
$dbname = 'tracks_service';
$user = 'osmap';
$pass = 'dzoriicon1';


return function () use ($host, $port, $dbname, $user, $pass) :PDO{
    try {
        return $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
};