<?php
namespace Base\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Cache\Cache;


class PermissaoComponent extends Component
{
	
	public $controller = null;
	
	public $config = [];
	
	public function initialize(array $config=[]) {
		
		parent::initialize($config);
		
		$this->config = $config + $this->config; 
		$this->controller = $this->_registry->getController();
	}
	
	public function getAcoes($tipo ){		
		
		$acoes = TableRegistry::get('Base.Acoes');
		
		$actions = Cache::read('actions_'.$tipo);
		if ($actions !== false) {
			//debug("cached");
			return $actions;
		}
		
		$actions = $acoes->find('all', ['conditions'=>['Acoes.tipo'=>$tipo,'Acoes.ativo'=>true]]);
		
		$act = [];
		foreach($actions as $action){
			$act[strtolower($action->prefix)][strtolower($action->controller)][strtolower($action->action)] = $action->id;
		}
		
		Cache::write('actions_'.$tipo, $act);
		//debug($act);
		
		return $act;
	}
	
	
	public function temPermissao($action=null, $controller=null, $plugin=null){
		
		//return true;
		
		$prefix 	= strtolower( $plugin ? $plugin : $this->controller->request->params['plugin'] );
		$controller = strtolower ($controller ? $controller : $this->controller->request->params['controller']);
		$action 	= strtolower( $action ? $action : $this->controller->request->params['action']);
		
		$vector[$prefix][$controller][$action] = 1;
		
		// se for public: permite
		if($this->ehPublic($action, $controller, $prefix)) 
			return true;
		
		// se usuario for admin: permite
		if($this->ehAdmin()) 
			return true;
		
		// verifica se o usuario tem a permissao
		return $this->usuarioTemPermissao($action, $controller, $prefix);
		
		
	}
	
	public function ehPublic($action, $controller, $plugin=null ){
		
		$public = $this->getAcoes('public');
		//debug($public);
		//debug($plugin);
		//debug($controller);
		//debug($action);
		return isset($public[strtolower($plugin)][strtolower($controller)][strtolower($action)]);
	}
	
	public function ehProtected($action, $controller, $plugin=null ){
	
		$public = $this->getAcoes('protectec');
		return isset($public[strtolower($plugin)][strtolower($controller)][strtolower($action)]);
	}
	
	public function ehPrivate($action, $controller, $plugin=null ){
	
		$public = $this->getAcoes('private');
		return isset($public[strtolower($plugin)][strtolower($controller)][strtolower($action)]);
	}
	
	public function usuarioTemPermissao($action, $controller, $plugin=null){
		$permissao =  $this->request->session()->read('permissao');
		if(!$permissao) return false;
		
		else return isset($permissao[strtolower($plugin)][strtolower($controller)][strtolower($action)]);
	}
	
	public function ehAdmin(){
		$user =  $this->request->session()->read('usuario');
		if(!$user) return false;
		else return $user['is_admin'];
	}
	
	public function estaLogado(){
		return $this->request->session()->check('login');
	}
	
	public function estaLogadoSistema(){
		return $this->request->session()->check('sistema');
	}
	
	
}