<?php
use Cake\Routing\Router;

Router::plugin(
    'Mater',
    ['path' => '/mater'],
    function ($routes) {
    	$routes->extensions(['json', 'xml', 'ajax']);
        $routes->fallbacks('DashedRoute');
    }
);
