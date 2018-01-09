<?php
use Cake\Routing\Router;

Router::plugin(
    'Tutorial',
    ['path' => '/tutorial'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
