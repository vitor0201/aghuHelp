<?php
use Cake\Routing\Router;

Router::plugin(
    'Sms',
    ['path' => '/sms'],
    function ($routes) {
    	$routes->extensions(['json', 'xml', 'ajax']);
        $routes->fallbacks('DashedRoute');
    }
);
