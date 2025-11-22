<?php

use Slim\App;
use org\osmap\controller\TrackController;

return function($app) {
    $app->get("/api/tracks", [TrackController::class,  "getTracks"]);
    $app->get("/api/display", [TrackController::class,  "getTracksForBounds"]);
    $app->get("/api/tracks/{userid}", [TrackController::class,  "getTracksByUserid"]);
    $app->get("/api/tracklist/{userid}", [TrackController::class,  "getTracksListByUserid"]);
    $app->get("/api/track/{userid}/{trackId}", [TrackController::class,  "getTrackByUserid"]);
    $app->post("/api/track", [TrackController::class,  "addTrack"]);
};
