<?php
use Org\Osmap\Db\Repository\TrackRepository;
use Psr\Container\ContainerInterface;

return function ($container) {    
        
    $container->set(PDO::class, function (ContainerInterface $c) {
        $settings = $c->get('settings');
        $db = $settings['database'];
        
        $dsn = "pgsql:host={$db['host']};dbname={$db['dbname']}";
        $pdo = new PDO($dsn, $db['user'], $db['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    });

    $container->set(TrackRepository::class, function (ContainerInterface $c){
        $pdo = $c->get(PDO::class);
        return new TrackRepository($pdo);
    });
};