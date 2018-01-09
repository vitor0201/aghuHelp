<?php
use Cake\Routing\Router;

Router::plugin(
    'Base',
    ['path' => '/base'],
    function ($routes) {
    	$routes->extensions(['json', 'xml', 'ajax']);
    	$routes->resources('Usuarios');
        $routes->fallbacks('DashedRoute');
    }
);
