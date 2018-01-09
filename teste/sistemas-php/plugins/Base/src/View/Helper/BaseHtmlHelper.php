<?php

/**
* Bootstrap Html Helper
*
*
* PHP 5
*
*  Licensed under the Apache License, Version 2.0 (the "License");
*  you may not use this file except in compliance with the License.
*  You may obtain a copy of the License at
*
*      http://www.apache.org/licenses/LICENSE-2.0
*
*
* @copyright Copyright (c) Mikaël Capelle (http://mikael-capelle.fr)
* @link http://mikael-capelle.fr
* @package app.View.Helper
* @since Apache v2
* @license http://www.apache.org/licenses/LICENSE-2.0
*/

namespace Base\View\Helper;

use Cake\View\Helper\HtmlHelper;
use Bootstrap\View\Helper\BootstrapHtmlHelper;
use Cake\Routing\Router;

class BaseHtmlHelper extends BootstrapHtmlHelper {

	public $PermissaoComponent = null;

    public function __construct (\Cake\View\View $view, array $config = []) {
    	
    	$this->PermissaoComponent = $config['PermissaoComponent'];
        parent::__construct($view, $config);
    }

    public function link($title, $url = null, array $options = []){
    	
    	$plugin 	= isset($url['plugin']) ? $url['plugin'] : $this->request->params['plugin'];
    	$controller = isset($url['controller']) ? $url['controller'] : $this->request->params['controller'];
    	$action 	= isset($url['action']) ? $url['action'] : 'index';
    	
    	//debug($plugin);
    	//debug($controller);
    	//debug($action);
    	
    	if(!$this->PermissaoComponent->temPermissao($action, $controller, $plugin))
    		return "";
    	
    	return parent::link($title, $url , $options);
    }
}

?>
