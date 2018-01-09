<?php
use Cake\Routing\Router;

Router::plugin(
    'Indicadores',
    ['path' => '/indicadores'],
    function ($routes) {
    	$routes->extensions(['json', 'xml', 'ajax']);
        $routes->fallbacks('DashedRoute');
    }
);

