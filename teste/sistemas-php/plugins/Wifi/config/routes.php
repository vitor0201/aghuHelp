<?php
use Cake\Routing\Router;

Router::plugin(
    'Wifi',
    ['path' => '/wifi'],
    function ($routes) {
    	$routes->extensions(['json', 'xml', 'ajax']);
        $routes->fallbacks('DashedRoute');
    }
);
