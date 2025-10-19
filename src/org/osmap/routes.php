<?php

use Slim\App;
use Org\Osmap\Controller\TrackController;

return function($app) {
    $app->get("/api/tracks", [TrackController::class,  "getTracks"]);
};
